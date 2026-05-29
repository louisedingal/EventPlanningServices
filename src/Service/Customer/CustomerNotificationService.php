<?php

namespace App\Service\Customer;

use App\Entity\EventRequest;
use App\Entity\User;
use App\Repository\EventRequestRepository;

/**
 * Builds in-app notification payloads from booking updates made on the website (admin).
 */
final class CustomerNotificationService
{
    public function __construct(
        private EventRequestRepository $eventRequestRepository,
    ) {
    }

    public function listForUser(User $user): array
    {
        $requests = $this->eventRequestRepository->findByUser($user);
        $notifications = [];

        foreach ($requests as $request) {
            if (CustomerEventRequestService::EDITABLE_STATUS === $request->getStatus()) {
                continue;
            }
            $notifications[] = $this->serializeNotification($request);
        }

        usort(
            $notifications,
            static fn (array $a, array $b): int => strcmp($b['createdAt'] ?? '', $a['createdAt'] ?? '')
        );

        return $notifications;
    }

    private function serializeNotification(EventRequest $request): array
    {
        $status = (string) $request->getStatus();
        $title = $request->getEventType() ?? 'Your booking';

        if ($package = $request->getServicePackage()) {
            $title = $package->getName() ?? $title;
        }

        return [
            'id' => sprintf('%d-%s', $request->getId(), $status),
            'eventRequestId' => $request->getId(),
            'title' => $title,
            'message' => $this->buildMessage($request, $status),
            'status' => $status,
            'createdAt' => $request->getCreatedAt()?->format(\DateTimeInterface::ATOM),
        ];
    }

    private function buildMessage(EventRequest $request, string $status): string
    {
        $notes = trim((string) $request->getAdminNotes());

        return match ($status) {
            'completed' => $notes !== ''
                ? $notes
                : 'Your booking request has been approved by our team.',
            'approved' => $notes !== ''
                ? $notes
                : 'Your booking request has been approved.',
            'rejected' => $notes !== ''
                ? $notes
                : 'Your booking request was declined. Contact Lux Events if you have questions.',
            'cancelled' => $notes !== ''
                ? $notes
                : 'Your booking request was cancelled.',
            default => $notes !== ''
                ? $notes
                : sprintf('Your booking status is now: %s.', $status),
        };
    }
}
