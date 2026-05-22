<?php

namespace App\Controller\Api\Customer;

use App\Api\Customer\CustomerApiResponse;
use App\Entity\User;
use App\Repository\EventRepository;
use App\Repository\EventRequestRepository;
use App\Repository\ServicePackageRepository;
use App\Repository\ThemeRepository;
use App\Repository\VenueRepository;
use App\Service\Customer\CustomerEventRequestService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/api/customer')]
#[IsGranted('ROLE_USER')]
final class CustomerDashboardController extends AbstractController
{
    public function __construct(
        private EventRequestRepository $eventRequestRepository,
        private VenueRepository $venueRepository,
        private ThemeRepository $themeRepository,
        private ServicePackageRepository $servicePackageRepository,
        private EventRepository $eventRepository,
        private CustomerEventRequestService $eventRequestService,
    ) {
    }

    #[Route('/dashboard', name: 'api_customer_dashboard', methods: ['GET'])]
    public function dashboard(): JsonResponse
    {
        /** @var User $user */
        $user = $this->getUser();
        $requests = $this->eventRequestRepository->findByUser($user);

        $pending = 0;
        foreach ($requests as $request) {
            if (CustomerEventRequestService::EDITABLE_STATUS === $request->getStatus()) {
                ++$pending;
            }
        }

        return CustomerApiResponse::success([
            'user' => [
                'username' => $user->getUsername(),
                'email' => $user->getEmail(),
                'isVerified' => $user->isVerified(),
            ],
            'requests' => [
                'total' => count($requests),
                'pending' => $pending,
            ],
            'catalog' => [
                'venues' => $this->venueRepository->count([]),
                'themes' => $this->themeRepository->count([]),
                'packages' => $this->servicePackageRepository->count([]),
                'sampleEvents' => $this->eventRepository->count([]),
            ],
        ]);
    }
}
