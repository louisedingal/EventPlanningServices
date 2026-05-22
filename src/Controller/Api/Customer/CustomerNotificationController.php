<?php

namespace App\Controller\Api\Customer;

use App\Api\Customer\CustomerApiResponse;
use App\Entity\User;
use App\Service\Customer\CustomerNotificationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/api/customer/notifications')]
#[IsGranted('ROLE_USER')]
final class CustomerNotificationController extends AbstractController
{
    public function __construct(
        private CustomerNotificationService $notificationService,
    ) {
    }

    #[Route('', name: 'api_customer_notifications_list', methods: ['GET'])]
    public function list(): JsonResponse
    {
        /** @var User $user */
        $user = $this->getUser();

        return CustomerApiResponse::items(
            $this->notificationService->listForUser($user)
        );
    }
}
