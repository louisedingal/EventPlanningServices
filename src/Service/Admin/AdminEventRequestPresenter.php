<?php

namespace App\Service\Admin;

use App\Entity\EventRequest;
use App\Service\EventRequestStyleImageResolver;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;

final class AdminEventRequestPresenter
{
    public function __construct(
        private readonly EventRequestStyleImageResolver $styleImageResolver,
        private readonly UrlGeneratorInterface $urlGenerator,
        private readonly CsrfTokenManagerInterface $csrfTokenManager,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function present(EventRequest $request, ?string $baseUrl = null): array
    {
        $id = $request->getId();
        $user = $request->getRequestedBy();

        return [
            'id' => $id,
            'createdAt' => $request->getCreatedAt()?->format('Y-m-d H:i'),
            'createdAtFull' => $request->getCreatedAt()?->format('Y-m-d H:i:s'),
            'isFromMobileApp' => $request->isFromMobileApp(),
            'source' => $request->getSourceLabel(),
            'clientEmail' => $user?->getEmail() ?? 'Deleted user',
            'eventType' => $request->getEventType(),
            'preferredDate' => $request->getPreferredDate()?->format('Y-m-d'),
            'guestCount' => $request->getEstimatedGuestCount(),
            'budget' => $request->getBudget(),
            'status' => $request->getStatus(),
            'venue' => $request->getPreferredVenue(),
            'theme' => $request->getTheme(),
            'preferredStyleLabel' => $request->getPreferredStyleLabel(),
            'preferredStyleImageUrl' => $this->styleImageResolver->resolveUrl($request, $baseUrl),
            'specialRequests' => $request->getSpecialRequests(),
            'servicePackage' => $request->getServicePackage()?->getName(),
            'preferredTime' => $request->getPreferredTime(),
            'markDoneUrl' => $this->urlGenerator->generate('app_admin_event_request_mark_done', ['id' => $id]),
            'markDoneToken' => $this->csrfTokenManager->getToken('mark_done_' . $id)->getValue(),
        ];
    }

    /**
     * @param EventRequest[] $requests
     *
     * @return array<int, array<string, mixed>>
     */
    public function presentMany(array $requests, ?string $baseUrl = null): array
    {
        return array_map(
            fn (EventRequest $request): array => $this->present($request, $baseUrl),
            $requests
        );
    }
}
