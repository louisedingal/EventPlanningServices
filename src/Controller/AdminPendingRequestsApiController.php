<?php

namespace App\Controller;

use App\Repository\EventRequestRepository;
use App\Service\Admin\AdminEventRequestPresenter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/admin/api')]
#[IsGranted('ROLE_STAFF')]
final class AdminPendingRequestsApiController extends AbstractController
{
    public function __construct(
        private readonly EventRequestRepository $eventRequestRepository,
        private readonly AdminEventRequestPresenter $presenter,
    ) {
    }

    #[Route('/pending-event-requests', name: 'app_admin_api_pending_requests', methods: ['GET'])]
    public function pendingRequests(Request $request): JsonResponse
    {
        $pending = $this->eventRequestRepository->findPending();
        $baseUrl = $request->getSchemeAndHttpHost();

        return $this->json([
            'count' => count($pending),
            'requests' => $this->presenter->presentMany($pending, $baseUrl),
        ]);
    }
}
