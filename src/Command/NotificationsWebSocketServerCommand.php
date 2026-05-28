<?php

namespace App\Command;

use App\Entity\User;
use App\Repository\EventRepository;
use App\Repository\EventRequestRepository;
use App\Repository\ServicePackageRepository;
use App\Repository\ThemeRepository;
use App\Repository\UserRepository;
use App\Repository\VenueRepository;
use App\Service\Customer\CustomerNotificationService;
use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Workerman\Connection\TcpConnection;
use Workerman\Protocols\Http\Request;
use Workerman\Timer;
use Workerman\Worker;

#[AsCommand(
    name: 'app:realtime:websocket-server',
    description: 'Runs WebSocket server for real-time customer/admin notifications.',
)]
final class NotificationsWebSocketServerCommand extends Command
{
    public function __construct(
        private readonly JWTEncoderInterface $jwtEncoder,
        private readonly UserRepository $userRepository,
        private readonly EventRequestRepository $eventRequestRepository,
        private readonly EventRepository $eventRepository,
        private readonly ThemeRepository $themeRepository,
        private readonly VenueRepository $venueRepository,
        private readonly ServicePackageRepository $servicePackageRepository,
        private readonly CustomerNotificationService $customerNotificationService,
        private readonly EntityManagerInterface $entityManager,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addOption('host', null, InputOption::VALUE_OPTIONAL, 'WebSocket host', '0.0.0.0')
            ->addOption('port', null, InputOption::VALUE_OPTIONAL, 'WebSocket port', '8081')
            ->addOption('interval', null, InputOption::VALUE_OPTIONAL, 'Polling interval in seconds', '2');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $host = (string) $input->getOption('host');
        $port = (int) $input->getOption('port');
        $interval = max(1, (int) $input->getOption('interval'));

        $worker = new Worker(sprintf('websocket://%s:%d', $host, $port));
        $worker->name = 'eventplanning-notifications-ws';
        $worker->count = 1;

        $worker->onWebSocketConnect = function (TcpConnection $connection, Request $request): void {
            $token = (string) ($request->get('token') ?? '');
            $user = $this->resolveUserFromJwt($token);
            if (!$user) {
                $connection->send(json_encode([
                    'type' => 'auth.error',
                    'message' => 'Invalid or expired token.',
                ], JSON_UNESCAPED_SLASHES));
                $connection->close();

                return;
            }

            $connection->user = $user;
            $connection->lastCustomerHash = null;
            $connection->lastCustomerRequestsHash = null;
            $connection->lastCustomerCatalogHash = null;
            $connection->lastAdminHash = null;
            $connection->lastAdminCatalogHash = null;

            $connection->send(json_encode([
                'type' => 'welcome',
                'userId' => $user->getId(),
            ], JSON_UNESCAPED_SLASHES));

            $this->sendUpdates($connection, true);
        };

        $worker->onClose = function (TcpConnection $connection): void {
            unset(
                $connection->user,
                $connection->lastCustomerHash,
                $connection->lastCustomerRequestsHash,
                $connection->lastCustomerCatalogHash,
                $connection->lastAdminHash,
                $connection->lastAdminCatalogHash
            );
        };

        $worker->onWorkerStart = function () use ($worker, $interval): void {
            Timer::add($interval, function () use ($worker): void {
                // Keep long-running Doctrine process fresh.
                $this->entityManager->clear();

                foreach ($worker->connections as $connection) {
                    if (!$connection instanceof TcpConnection || !isset($connection->user)) {
                        continue;
                    }
                    $this->sendUpdates($connection, false);
                }
            });
        };

        $output->writeln(sprintf(
            'WebSocket server listening on ws://%s:%d (interval: %ds)',
            $host,
            $port,
            $interval
        ));

        Worker::runAll();

        return Command::SUCCESS;
    }

    private function resolveUserFromJwt(string $token): ?User
    {
        if ($token === '') {
            return null;
        }

        try {
            $payload = $this->jwtEncoder->decode($token);
        } catch (\Throwable) {
            return null;
        }

        $identifier = (string) ($payload['username'] ?? '');
        if ($identifier === '') {
            return null;
        }

        return $this->userRepository->findOneBy(['email' => $identifier]);
    }

    private function sendUpdates(TcpConnection $connection, bool $force): void
    {
        /** @var User $user */
        $user = $connection->user;
        $roles = $user->getRoles();

        if (in_array('ROLE_USER', $roles, true)) {
            $customerNotifications = $this->customerNotificationService->listForUser($user);
            $customerHash = sha1(json_encode($customerNotifications, JSON_UNESCAPED_SLASHES) ?: '');
            if ($force || $connection->lastCustomerHash !== $customerHash) {
                $connection->send(json_encode([
                    'type' => 'customer.notifications.updated',
                    'count' => count($customerNotifications),
                ], JSON_UNESCAPED_SLASHES));
                $connection->lastCustomerHash = $customerHash;
            }

            $requestSnapshot = array_map(
                static fn ($request): array => [
                    'id' => $request->getId(),
                    'status' => $request->getStatus(),
                    'eventType' => $request->getEventType(),
                    'preferredDate' => $request->getPreferredDate()?->format('Y-m-d'),
                    'preferredTime' => $request->getPreferredTime(),
                    'budget' => $request->getBudget(),
                    'adminNotes' => $request->getAdminNotes(),
                    'paymentAmount' => $request->getPaymentAmount(),
                    'paymentApprovedAt' => $request->getPaymentApprovedAt()?->format(\DateTimeInterface::ATOM),
                    'receiptNumber' => $request->getReceiptNumber(),
                ],
                $this->eventRequestRepository->findByUser($user)
            );
            $requestHash = sha1(json_encode($requestSnapshot, JSON_UNESCAPED_SLASHES) ?: '');
            if ($force || $connection->lastCustomerRequestsHash !== $requestHash) {
                $connection->send(json_encode([
                    'type' => 'customer.event_requests.updated',
                    'count' => count($requestSnapshot),
                ], JSON_UNESCAPED_SLASHES));
                $connection->lastCustomerRequestsHash = $requestHash;
            }

            $catalogSnapshot = $this->buildCatalogSnapshot();
            $catalogHash = sha1(json_encode($catalogSnapshot, JSON_UNESCAPED_SLASHES) ?: '');
            if ($force || $connection->lastCustomerCatalogHash !== $catalogHash) {
                $connection->send(json_encode([
                    'type' => 'customer.catalog.updated',
                ], JSON_UNESCAPED_SLASHES));
                $connection->lastCustomerCatalogHash = $catalogHash;
            }
        }

        if (in_array('ROLE_STAFF', $roles, true) || in_array('ROLE_ADMIN', $roles, true)) {
            $pending = $this->eventRequestRepository->findPending();
            $pendingSnapshot = array_map(
                static fn ($request): array => [
                    'id' => $request->getId(),
                    'status' => $request->getStatus(),
                    'createdAt' => $request->getCreatedAt()?->format(\DateTimeInterface::ATOM),
                ],
                $pending
            );
            $adminHash = sha1(json_encode($pendingSnapshot, JSON_UNESCAPED_SLASHES) ?: '');
            if ($force || $connection->lastAdminHash !== $adminHash) {
                $connection->send(json_encode([
                    'type' => 'admin.pending_requests.updated',
                    'count' => count($pendingSnapshot),
                ], JSON_UNESCAPED_SLASHES));
                $connection->lastAdminHash = $adminHash;
            }

            $adminCatalogSnapshot = $this->buildCatalogSnapshot();
            $adminCatalogHash = sha1(json_encode($adminCatalogSnapshot, JSON_UNESCAPED_SLASHES) ?: '');
            if ($force || $connection->lastAdminCatalogHash !== $adminCatalogHash) {
                $connection->send(json_encode([
                    'type' => 'admin.catalog.updated',
                ], JSON_UNESCAPED_SLASHES));
                $connection->lastAdminCatalogHash = $adminCatalogHash;
            }
        }
    }

    private function buildCatalogSnapshot(): array
    {
        $events = array_map(
            static fn ($event): array => [
                'id' => $event->getId(),
                'eventType' => $event->getEventType(),
                'customerName' => $event->getCustomerName(),
                'eventDate' => $event->getEventDate()?->format('Y-m-d'),
                'price' => $event->getPrice(),
            ],
            $this->eventRepository->findAll()
        );
        $themes = array_map(
            static fn ($theme): array => [
                'id' => $theme->getId(),
                'name' => $theme->getName(),
                'eventType' => $theme->getEventType(),
                'description' => $theme->getDescription(),
            ],
            $this->themeRepository->findAll()
        );
        $venues = array_map(
            static fn ($venue): array => [
                'id' => $venue->getId(),
                'name' => $venue->getName(),
                'address' => $venue->getAddress(),
                'capacity' => $venue->getCapacity(),
            ],
            $this->venueRepository->findAll()
        );
        $packages = array_map(
            static fn ($package): array => [
                'id' => $package->getId(),
                'name' => $package->getName(),
                'price' => $package->getPrice(),
                'description' => $package->getDescription(),
            ],
            $this->servicePackageRepository->findAll()
        );

        return [
            'events' => $events,
            'themes' => $themes,
            'venues' => $venues,
            'packages' => $packages,
        ];
    }
}
