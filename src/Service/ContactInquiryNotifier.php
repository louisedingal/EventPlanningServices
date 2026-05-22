<?php

namespace App\Service;

use Psr\Log\LoggerInterface;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;

/**
 * Sends landing-page contact inquiries via Symfony Mailer (SMTP, including Brevo SMTP).
 * Configure CONTACT_INBOX_EMAIL (defaults to MAILER_FROM_ADDRESS if empty).
 */
final class ContactInquiryNotifier
{
    public function __construct(
        private readonly MailerInterface $mailer,
        private readonly LoggerInterface $logger,
        private readonly string $fromAddress,
        private readonly string $fromName,
        private readonly string $inboxEmail,
    ) {
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function send(string $name, string $email, string $message): void
    {
        $to = trim($this->inboxEmail) !== '' ? trim($this->inboxEmail) : $this->fromAddress;

        $safeName = $name === '' ? 'Visitor' : $name;
        $subject = sprintf('[Lux Events] Contact: %s', mb_substr($safeName, 0, 60));

        $textBody = sprintf(
            "New message from the website contact form.\n\nName: %s\nEmail: %s\n\nMessage:\n%s\n",
            $name,
            $email,
            $message
        );

        $htmlBody = sprintf(
            '<p><strong>Name:</strong> %s<br><strong>Email:</strong> <a href="mailto:%s">%s</a></p><p><strong>Message:</strong></p><p>%s</p>',
            htmlspecialchars($name, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'),
            htmlspecialchars($email, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'),
            htmlspecialchars($email, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'),
            nl2br(htmlspecialchars($message, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'))
        );

        $messageEmail = (new Email())
            ->from(new Address($this->fromAddress, $this->fromName))
            ->to($to)
            ->replyTo(new Address($email, $safeName))
            ->subject($subject)
            ->text($textBody)
            ->html($htmlBody);

        $this->mailer->send($messageEmail);
    }

    public function logFailure(\Throwable $e, string $contextEmail): void
    {
        $this->logger->error('Contact form delivery failed', [
            'exception' => $e->getMessage(),
            'visitor_email' => $contextEmail,
        ]);
    }
}
