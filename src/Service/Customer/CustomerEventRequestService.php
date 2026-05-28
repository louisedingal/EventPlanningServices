<?php

namespace App\Service\Customer;

use App\Entity\EventRequest;
use App\Entity\ServicePackage;
use App\Entity\User;
use App\Repository\EventRequestRepository;
use App\Repository\ServicePackageRepository;
use App\Service\EventRequestNotifier;
use App\Service\EventRequestStyleImageResolver;
use App\Service\ServicePackageImageUrlResolver;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final class CustomerEventRequestService
{
    public const EDITABLE_STATUS = 'pending';

    public function __construct(
        private EntityManagerInterface $entityManager,
        private EventRequestRepository $eventRequestRepository,
        private ServicePackageRepository $servicePackageRepository,
        private EventRequestNotifier $eventRequestNotifier,
        private ServicePackageImageUrlResolver $packageImageUrlResolver,
        private EventRequestStyleImageResolver $styleImageResolver,
        private string $defaultUri = 'http://127.0.0.1:8000',
    ) {
    }

    public function listForUser(User $user): array
    {
        return $this->eventRequestRepository->findByUser($user);
    }

    public function getForUser(User $user, int $id): EventRequest
    {
        $request = $this->eventRequestRepository->find($id);
        if (!$request) {
            throw new NotFoundHttpException('Event request not found.');
        }
        $this->assertOwner($user, $request);

        return $request;
    }

    public function create(User $user, array $payload): EventRequest
    {
        $request = new EventRequest();
        $request->setRequestedBy($user);
        $request->setSource(EventRequest::SOURCE_MOBILE);
        $this->applyPayload($request, $payload, true);
        if ($request->getServicePackage()) {
            $this->assertServiceBookingFields($request);
        }

        $this->entityManager->persist($request);
        $this->entityManager->flush();

        $this->eventRequestNotifier->notifyNew($request);

        return $request;
    }

    public function update(User $user, int $id, array $payload): EventRequest
    {
        $request = $this->getForUser($user, $id);
        $this->assertEditable($request);
        $this->applyPayload($request, $payload, false);
        $this->entityManager->flush();

        return $request;
    }

    public function delete(User $user, int $id): void
    {
        $request = $this->getForUser($user, $id);
        $this->assertEditable($request);
        $this->entityManager->remove($request);
        $this->entityManager->flush();
    }

    public function serialize(EventRequest $request): array
    {
        return [
            'id' => $request->getId(),
            'eventType' => $request->getEventType(),
            'preferredDate' => $request->getPreferredDate()?->format('Y-m-d'),
            'preferredTime' => $request->getPreferredTime(),
            'estimatedGuestCount' => $request->getEstimatedGuestCount(),
            'preferredVenue' => $request->getPreferredVenue(),
            'theme' => $request->getTheme(),
            'preferredStyleLabel' => $request->getPreferredStyleLabel(),
            'preferredStyleImagePath' => $request->getPreferredStyleImagePath(),
            'preferredStyleImageUrl' => $this->packageImageUrlResolver->resolve(
                $request->getPreferredStyleImagePath(),
                $this->defaultUri
            ),
            'specialRequests' => $request->getSpecialRequests(),
            'budget' => $request->getBudget(),
            'servicePackage' => $this->serializeServicePackage($request->getServicePackage()),
            'status' => $request->getStatus(),
            'createdAt' => $request->getCreatedAt()?->format(\DateTimeInterface::ATOM),
            'canEdit' => self::EDITABLE_STATUS === $request->getStatus(),
            'canApprovePayment' => $this->canApprovePayment($request),
            'adminNotes' => 'completed' === $request->getStatus()
                ? $request->getAdminNotes()
                : null,
            'payment' => [
                'amount' => $request->getPaymentAmount() !== null ? (float) $request->getPaymentAmount() : null,
                'approvedAt' => $request->getPaymentApprovedAt()?->format(\DateTimeInterface::ATOM),
                'receiptNumber' => $request->getReceiptNumber(),
            ],
        ];
    }

    public function approvePayment(User $user, int $id): EventRequest
    {
        $request = $this->getForUser($user, $id);
        if (!$this->canApprovePayment($request)) {
            throw new BadRequestHttpException('Payment cannot be approved for this request yet.');
        }

        $amount = $this->resolvePayableAmount($request);
        if ($amount <= 0) {
            throw new BadRequestHttpException('Invalid payable amount.');
        }

        $request->setPaymentAmount(number_format($amount, 2, '.', ''));
        $request->setPaymentApprovedAt(new \DateTimeImmutable());
        $request->setReceiptNumber($this->generateReceiptNumber($request));
        $request->setStatus('approved');
        $this->entityManager->flush();

        return $request;
    }

    private function applyPayload(EventRequest $request, array $payload, bool $isCreate): void
    {
        $linkedPackage = null;
        if ($isCreate && !empty($payload['servicePackageId'])) {
            $linkedPackage = $this->resolveServicePackage((int) $payload['servicePackageId']);
            $request->setServicePackage($linkedPackage);
            $request->setEventType('Service: '.$linkedPackage->getName());
            $request->setBudget(number_format((float) $linkedPackage->getPrice(), 2, '.', ''));
        }

        if (null === $linkedPackage && ($isCreate || array_key_exists('eventType', $payload))) {
            $eventType = trim((string) ($payload['eventType'] ?? ''));
            if ($eventType === '') {
                throw new BadRequestHttpException('Event type is required.');
            }
            $request->setEventType($eventType);
        }

        if (array_key_exists('preferredDate', $payload)) {
            $dateRaw = $payload['preferredDate'];
            if ($dateRaw === null || $dateRaw === '') {
                $request->setPreferredDate(null);
            } else {
                try {
                    $request->setPreferredDate(new \DateTime((string) $dateRaw));
                } catch (\Exception) {
                    throw new BadRequestHttpException('Invalid preferred date. Use YYYY-MM-DD.');
                }
            }
        }

        if (array_key_exists('preferredTime', $payload)) {
            $timeRaw = $payload['preferredTime'];
            if ($timeRaw === null || $timeRaw === '') {
                $request->setPreferredTime(null);
            } else {
                $time = trim((string) $timeRaw);
                if (!preg_match('/^\d{1,2}:\d{2}(:\d{2})?$/', $time)) {
                    throw new BadRequestHttpException('Invalid preferred time. Use HH:MM.');
                }
                $request->setPreferredTime(strlen($time) > 5 ? substr($time, 0, 5) : $time);
            }
        }

        if (array_key_exists('estimatedGuestCount', $payload)) {
            $guests = $payload['estimatedGuestCount'];
            $request->setEstimatedGuestCount(
                $guests === null || $guests === '' ? null : max(0, (int) $guests)
            );
        }

        if (array_key_exists('preferredVenue', $payload)) {
            $request->setPreferredVenue($this->nullableString($payload['preferredVenue']));
        }

        if (array_key_exists('theme', $payload)) {
            $request->setTheme($this->nullableString($payload['theme']));
        }

        if ($isCreate || array_key_exists('preferredStyleLabel', $payload) || array_key_exists('styleLook', $payload)) {
            $label = $payload['preferredStyleLabel'] ?? $payload['styleLook'] ?? null;
            $request->setPreferredStyleLabel($this->nullableString($label));
        }

        if ($isCreate || array_key_exists('preferredStyleImagePath', $payload) || array_key_exists('styleLookImagePath', $payload)) {
            $path = $payload['preferredStyleImagePath'] ?? $payload['styleLookImagePath'] ?? null;
            if (($path === null || trim((string) $path) === '')
                && $request->getPreferredStyleLabel()
                && $request->getTheme()) {
                $path = $this->styleImageResolver->resolvePathFromThemeAndLabel(
                    $request->getTheme(),
                    $request->getPreferredStyleLabel()
                );
            }
            $request->setPreferredStyleImagePath(
                $path !== null && trim((string) $path) !== ''
                    ? $this->sanitizeStyleImagePath($path)
                    : null
            );
        }

        if (null !== $linkedPackage && $isCreate) {
            $parts = [];
            $userNotes = $this->nullableString($payload['specialRequests'] ?? null);
            if (null !== $userNotes) {
                $parts[] = $userNotes;
            }
            $parts[] = sprintf(
                'Service booking for package "%s" (₱%s).',
                $linkedPackage->getName(),
                number_format((float) $linkedPackage->getPrice(), 2)
            );
            $request->setSpecialRequests(implode("\n\n", $parts));
        } elseif (array_key_exists('specialRequests', $payload)) {
            $request->setSpecialRequests($this->nullableString($payload['specialRequests']));
        }

        if (array_key_exists('budget', $payload) && null === $linkedPackage) {
            $budget = $this->nullableString($payload['budget']);
            if (null !== $budget) {
                $budget = trim(preg_replace('/[^0-9\s.,\-]/', '', $budget) ?? '');
                $budget = $budget !== '' ? $budget : null;
            }
            $request->setBudget($budget);
        }
    }

    private function resolveServicePackage(int $id): ServicePackage
    {
        $package = $this->servicePackageRepository->find($id);
        if (!$package) {
            throw new NotFoundHttpException('Service package not found.');
        }

        return $package;
    }

    private function assertServiceBookingFields(EventRequest $request): void
    {
        if (!$request->getPreferredDate()) {
            throw new BadRequestHttpException('Preferred date is required for service bookings.');
        }
        if (!$request->getPreferredTime()) {
            throw new BadRequestHttpException('Preferred time is required for service bookings.');
        }
    }

    private function serializeServicePackage(?ServicePackage $package): ?array
    {
        if (!$package) {
            return null;
        }

        return [
            'id' => $package->getId(),
            'name' => $package->getName(),
            'description' => $package->getDescription(),
            'price' => $package->getPrice(),
            'imageUrl' => $this->packageImageUrlResolver->resolve(
                $package->getImagePath(),
                $this->defaultUri
            ),
        ];
    }

    private function nullableString(mixed $value): ?string
    {
        if ($value === null) {
            return null;
        }
        $trimmed = trim((string) $value);

        return $trimmed === '' ? null : $trimmed;
    }

    private function sanitizeStyleImagePath(mixed $value): ?string
    {
        $path = $this->nullableString($value);
        if (null === $path) {
            return null;
        }

        $path = ltrim(str_replace('\\', '/', $path), '/');
        if (!str_starts_with($path, 'uploads/theme-samples/')) {
            throw new BadRequestHttpException('Invalid style image path.');
        }

        return $path;
    }

    private function assertOwner(User $user, EventRequest $request): void
    {
        $owner = $request->getRequestedBy();
        if (!$owner || $owner->getId() !== $user->getId()) {
            throw new AccessDeniedHttpException('You do not have access to this event request.');
        }
    }

    private function assertEditable(EventRequest $request): void
    {
        if (self::EDITABLE_STATUS !== $request->getStatus()) {
            throw new BadRequestHttpException(
                'Only pending requests can be changed. Contact support for updates.'
            );
        }
    }

    private function canApprovePayment(EventRequest $request): bool
    {
        return null === $request->getPaymentApprovedAt() && $this->resolvePayableAmount($request) > 0;
    }

    private function resolvePayableAmount(EventRequest $request): float
    {
        if ($request->getServicePackage()) {
            return (float) $request->getServicePackage()->getPrice();
        }

        $budget = $request->getBudget();
        if ($budget === null || trim($budget) === '') {
            return 0.0;
        }

        $clean = preg_replace('/[^0-9.\-]/', '', $budget) ?? '';
        if ($clean === '' || !is_numeric($clean)) {
            return 0.0;
        }

        return max(0.0, (float) $clean);
    }

    private function generateReceiptNumber(EventRequest $request): string
    {
        return sprintf(
            'REC-%s-%d-%s',
            (new \DateTimeImmutable())->format('Ymd'),
            $request->getId(),
            substr(bin2hex(random_bytes(3)), 0, 6)
        );
    }
}
