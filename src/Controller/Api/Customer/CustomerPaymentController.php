<?php

namespace App\Controller\Api\Customer;

use App\Api\Customer\CustomerApiResponse;
use App\Entity\User;
use App\Service\Customer\CustomerPaymentService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/api/customer/payments')]
#[IsGranted('ROLE_USER')]
final class CustomerPaymentController extends AbstractController
{
    public function __construct(
        private CustomerPaymentService $paymentService,
    ) {
    }

    #[Route('', name: 'api_customer_payments_list', methods: ['GET'])]
    public function list(): JsonResponse
    {
        /** @var User $user */
        $user = $this->getUser();
        $items = array_map(
            fn ($payment) => $this->paymentService->serialize($payment),
            $this->paymentService->listForUser($user)
        );

        return CustomerApiResponse::items($items);
    }

    #[Route('/{id}', name: 'api_customer_payments_get', methods: ['GET'], requirements: ['id' => '\d+'])]
    public function getOne(int $id): JsonResponse
    {
        /** @var User $user */
        $user = $this->getUser();
        $payment = $this->paymentService->getForUser($user, $id);

        return CustomerApiResponse::success($this->paymentService->serialize($payment));
    }
}
