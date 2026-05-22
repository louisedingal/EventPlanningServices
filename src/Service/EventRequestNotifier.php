<?php

namespace App\Service;

use App\Entity\EventRequest;
use Psr\Log\LoggerInterface;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * Notifies staff when a customer submits an event customization request (mobile or web).
 */
final class EventRequestNotifier
{
    public function __construct(
        private readonly MailerInterface $mailer,
        private readonly LoggerInterface $logger,
        private readonly ActivityLogService $activityLogService,
        private readonly UrlGeneratorInterface $urlGenerator,
        private readonly string $fromAddress,
        private readonly string $fromName,
        private readonly string $inboxEmail,
        private readonly string $defaultUri,
    ) {
    }

    public function notifyNew(EventRequest $request): void
    {
        $user = $request->getRequestedBy();
        $sourceLabel = $request->getSourceLabel();
        $clientEmail = $user?->getEmail() ?? 'Unknown';
        $eventType = $request->getEventType() ?? 'Event';

        $description = sprintf(
            'New %s event request: %s from %s',
            strtolower($sourceLabel),
            $eventType,
            $clientEmail
        );

        $this->activityLogService->log(
            $user,
            'Event Request',
            'EventRequest',
            $request->getId(),
            [
                'eventType' => $eventType,
                'source' => $request->getSource(),
                'status' => $request->getStatus(),
            ],
            $description
        );

        try {
            $this->sendAdminEmail($request, $sourceLabel, $clientEmail);
        } catch (TransportExceptionInterface $e) {
            $this->logger->error('Event request admin email failed', [
                'exception' => $e->getMessage(),
                'request_id' => $request->getId(),
                'client_email' => $clientEmail,
            ]);
        }
    }

    /**
     * @throws TransportExceptionInterface
     */
    private function sendAdminEmail(EventRequest $request, string $sourceLabel, string $clientEmail): void
    {
        $to = trim($this->inboxEmail) !== '' ? trim($this->inboxEmail) : $this->fromAddress;
        $eventType = $request->getEventType() ?? 'Event';
        $subject = sprintf('[Lux Events] New %s request: %s', $sourceLabel, mb_substr($eventType, 0, 50));

        $adminUrl = rtrim($this->defaultUri, '/').$this->urlGenerator->generate(
            'app_admin_pending_requests',
            referenceType: UrlGeneratorInterface::ABSOLUTE_PATH
        );

        $packageName = $request->getServicePackage()?->getName();
        $preferredDate = $request->getPreferredDate()?->format('Y-m-d') ?? '-';
        $preferredTime = $request->getPreferredTime() ?? '-';
        $guests = $request->getEstimatedGuestCount() ?? '-';
        $budget = $request->getBudget() ?? '-';
        $venue = $request->getPreferredVenue() ?? '-';
        $theme = $request->getTheme() ?? '-';
        $special = $request->getSpecialRequests() ?? '-';

        $textBody = sprintf(
            "A customer submitted a new event customization request.\n\n".
            "Source: %s\nClient: %s\nEvent type: %s\nService package: %s\nPreferred date: %s\nPreferred time: %s\nGuests: %s\nBudget: %s\nVenue: %s\nTheme: %s\n\nSpecial requests:\n%s\n\nReview in admin:\n%s\n",
            $sourceLabel,
            $clientEmail,
            $eventType,
            $packageName ?? '-',
            $preferredDate,
            $preferredTime,
            (string) $guests,
            $budget,
            $venue,
            $theme,
            $special,
            $adminUrl
        );

        $htmlBody = sprintf(
            '<p>A customer submitted a new event customization request via <strong>%s</strong>.</p>'.
            '<table style="border-collapse:collapse;width:100%%;max-width:520px">' .
            '<tr><td style="padding:6px 12px 6px 0;color:#64748b"><strong>Client</strong></td><td>%s</td></tr>' .
            '<tr><td style="padding:6px 12px 6px 0;color:#64748b"><strong>Event type</strong></td><td>%s</td></tr>' .
            '<tr><td style="padding:6px 12px 6px 0;color:#64748b"><strong>Service package</strong></td><td>%s</td></tr>' .
            '<tr><td style="padding:6px 12px 6px 0;color:#64748b"><strong>Preferred date</strong></td><td>%s</td></tr>' .
            '<tr><td style="padding:6px 12px 6px 0;color:#64748b"><strong>Preferred time</strong></td><td>%s</td></tr>' .
            '<tr><td style="padding:6px 12px 6px 0;color:#64748b"><strong>Guests</strong></td><td>%s</td></tr>' .
            '<tr><td style="padding:6px 12px 6px 0;color:#64748b"><strong>Budget</strong></td><td>%s</td></tr>' .
            '<tr><td style="padding:6px 12px 6px 0;color:#64748b"><strong>Venue</strong></td><td>%s</td></tr>' .
            '<tr><td style="padding:6px 12px 6px 0;color:#64748b"><strong>Theme</strong></td><td>%s</td></tr>' .
            '</table>' .
            '<p><strong>Special requests:</strong></p><p style="white-space:pre-wrap">%s</p>' .
            '<p><a href="%s">Open pending requests in admin</a></p>',
            htmlspecialchars($sourceLabel, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'),
            htmlspecialchars($clientEmail, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'),
            htmlspecialchars($eventType, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'),
            htmlspecialchars($packageName ?? '-', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'),
            htmlspecialchars($preferredDate, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'),
            htmlspecialchars($preferredTime, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'),
            htmlspecialchars((string) $guests, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'),
            htmlspecialchars($budget, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'),
            htmlspecialchars($venue, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'),
            htmlspecialchars($theme, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'),
            nl2br(htmlspecialchars($special, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8')),
            htmlspecialchars($adminUrl, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8')
        );

        $email = (new Email())
            ->from(new Address($this->fromAddress, $this->fromName))
            ->to($to)
            ->subject($subject)
            ->text($textBody)
            ->html($htmlBody);

        if ($user = $request->getRequestedBy()) {
            $email->replyTo(new Address($user->getEmail(), $user->getUsername() ?? $user->getEmail()));
        }

        $this->mailer->send($email);
    }
}
