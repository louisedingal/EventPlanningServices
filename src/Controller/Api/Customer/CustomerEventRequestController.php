<?php

namespace App\Controller\Api\Customer;

use App\Api\Customer\CustomerApiResponse;
use App\Entity\User;
use App\Service\Customer\CustomerEventRequestService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/api/customer/event-requests')]
#[IsGranted('ROLE_USER')]
final class CustomerEventRequestController extends AbstractController
{
    public function __construct(
        private CustomerEventRequestService $eventRequestService,
    ) {
    }

    #[Route('', name: 'api_customer_event_requests_list', methods: ['GET'])]
    public function list(): JsonResponse
    {
        /** @var User $user */
        $user = $this->getUser();
        $items = array_map(
            fn ($r) => $this->eventRequestService->serialize($r),
            $this->eventRequestService->listForUser($user)
        );

        return CustomerApiResponse::items($items);
    }

    #[Route('', name: 'api_customer_event_requests_create', methods: ['POST'])]
    public function create(Request $request): JsonResponse
    {
        /** @var User $user */
        $user = $this->getUser();
        $payload = $this->decodeJson($request);
        $created = $this->eventRequestService->create($user, $payload);

        return CustomerApiResponse::success(
            $this->eventRequestService->serialize($created),
            201
        );
    }

    #[Route('/{id}', name: 'api_customer_event_requests_get', methods: ['GET'], requirements: ['id' => '\d+'])]
    public function get(int $id): JsonResponse
    {
        /** @var User $user */
        $user = $this->getUser();
        $item = $this->eventRequestService->getForUser($user, $id);

        return CustomerApiResponse::success($this->eventRequestService->serialize($item));
    }

    #[Route('/{id}', name: 'api_customer_event_requests_update', methods: ['PUT'])]
    public function update(int $id, Request $request): JsonResponse
    {
        /** @var User $user */
        $user = $this->getUser();
        $payload = $this->decodeJson($request);
        $updated = $this->eventRequestService->update($user, $id, $payload);

        return CustomerApiResponse::success($this->eventRequestService->serialize($updated));
    }

    #[Route('/{id}', name: 'api_customer_event_requests_delete', methods: ['DELETE'], requirements: ['id' => '\d+'])]
    public function delete(int $id): JsonResponse
    {
        /** @var User $user */
        $user = $this->getUser();
        $this->eventRequestService->delete($user, $id);

        return CustomerApiResponse::success(['deleted' => true]);
    }

    private function decodeJson(Request $request): array
    {
        $data = json_decode($request->getContent(), true);
        if (!is_array($data)) {
            throw new BadRequestHttpException('Invalid JSON body.');
        }

        return $data;
    }
}
