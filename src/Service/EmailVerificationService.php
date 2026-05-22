<?php

namespace App\Service;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class EmailVerificationService
{
    private string $fromAddress;
    private string $fromName;

    public function __construct(
        private EntityManagerInterface $entityManager,
        private MailerInterface $mailer,
        private UrlGeneratorInterface $urlGenerator,
        #[Autowire('%env(MAILER_FROM_ADDRESS)%')] string $fromAddress,
        #[Autowire('%env(MAILER_FROM_NAME)%')] string $fromName,
    ) {
        $this->fromAddress = trim($fromAddress, " \t\n\r\0\x0B\"'");
        $this->fromName = trim($fromName, " \t\n\r\0\x0B\"'");
    }

    /**
     * Generate a unique verification token
     */
    public function generateVerificationToken(): string
    {
        return bin2hex(random_bytes(32));
    }

    /**
     * Send verification email to user
     */
    public function sendVerificationEmail(User $user, string $verificationUrl): void
    {
        $email = (new TemplatedEmail())
            ->from(new Address($this->fromAddress, $this->fromName))
            ->replyTo(new Address($this->fromAddress, $this->fromName))
            ->to(new Address($user->getEmail()))
            ->subject('Please verify your email address')
            ->htmlTemplate('emails/verification.html.twig')
            ->textTemplate('emails/verification.txt.twig')
            ->context([
                'user' => $user,
                'verificationUrl' => $verificationUrl,
            ]);

        try {
            $this->mailer->send($email);
        } catch (TransportExceptionInterface $e) {
            // Bubble up a clear error so the UI can show it.
            throw $e;
        }
    }

    /**
     * Verify a token and mark user as verified (shared by Web GET /verify-email/{token} and API).
     */
    public function verifyToken(string $token): ?User
    {
        $token = trim($token);
        if ($token === '') {
            return null;
        }

        $user = $this->entityManager
            ->getRepository(User::class)
            ->findOneBy(['verificationToken' => $token]);

        if (!$user) {
            return null;
        }

        $user->setIsVerified(true);
        $user->setVerificationToken(null);

        $this->entityManager->flush();

        return $user;
    }

    /**
     * Issue a new token and send the verification email if the address belongs to an unverified user.
     * Callers should use a generic success message (do not reveal whether the email exists).
     *
     * @throws TransportExceptionInterface
     */
    public function resendVerificationLinkByEmail(string $email): void
    {
        $email = trim($email);
        if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return;
        }

        $user = $this->entityManager->getRepository(User::class)->findOneBy(['email' => $email]);
        if (!$user instanceof User || $user->isVerified()) {
            return;
        }

        $verificationToken = $this->generateVerificationToken();
        $user->setVerificationToken($verificationToken);
        $this->entityManager->flush();

        $verificationUrl = $this->urlGenerator->generate(
            'app_verify_email',
            ['token' => $verificationToken],
            UrlGeneratorInterface::ABSOLUTE_URL
        );

        $this->sendVerificationEmail($user, $verificationUrl);
    }

    /**
     * Check if a user needs verification
     */
    public function needsVerification(User $user): bool
    {
        return !$user->isVerified();
    }
}