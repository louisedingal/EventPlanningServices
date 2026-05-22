<?php

namespace App\Security;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Service\ActivityLogService;
use Doctrine\ORM\EntityManagerInterface;
use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use KnpU\OAuth2ClientBundle\Security\Authenticator\OAuth2Authenticator;
use League\OAuth2\Client\Token\AccessToken;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;

final class GoogleAuthenticator extends OAuth2Authenticator
{
    public function __construct(
        private readonly ClientRegistry $clientRegistry,
        private readonly UrlGeneratorInterface $urlGenerator,
        private readonly UserRepository $userRepository,
        private readonly EntityManagerInterface $entityManager,
        private readonly ActivityLogService $activityLogService,
        private readonly UserPasswordHasherInterface $passwordHasher,
    ) {
    }

    public function supports(Request $request): ?bool
    {
        return $request->attributes->get('_route') === 'app_connect_google_check';
    }

    public function authenticate(Request $request): SelfValidatingPassport
    {
        $client = $this->clientRegistry->getClient('google_main');
        /** @var AccessToken $accessToken */
        $accessToken = $this->fetchAccessToken($client);
        $googleUser = $client->fetchUserFromToken($accessToken);

        $email = strtolower(trim((string) $googleUser->getEmail()));
        if ($email === '') {
            throw new CustomUserMessageAuthenticationException('Google login failed: no email address returned.');
        }

        $user = $this->userRepository->findOneBy(['email' => $email]);
        if (!$user instanceof User) {
            // Create a normal user account on first Google login.
            $user = new User();
            $user->setEmail($email);
            $user->setRoles(['ROLE_USER']);

            // Try to derive a username from email (optional field) and keep it unique.
            $base = preg_replace('/[^a-z0-9._-]/', '', strtolower((string) strstr($email, '@', true))) ?: 'user';
            $candidate = mb_substr($base, 0, 40);
            $suffix = 0;
            while ($this->userRepository->findOneBy(['username' => $candidate])) {
                $suffix++;
                $candidate = mb_substr($base, 0, 35) . '_' . $suffix;
                if ($suffix > 500) {
                    break;
                }
            }
            $user->setUsername($candidate);

            // Password is required by the entity; set a random one (user will sign in via Google).
            $randomPassword = bin2hex(random_bytes(16));
            $user->setPassword($this->passwordHasher->hashPassword($user, $randomPassword));

            $this->entityManager->persist($user);
        }

        $updated = false;
        if (!$user->isVerified()) {
            $user->setIsVerified(true);
            $updated = true;
        }
        if ($user->getVerificationToken() !== null) {
            $user->setVerificationToken(null);
            $updated = true;
        }
        if ($updated) {
            $this->entityManager->flush();
        }

        return new SelfValidatingPassport(new UserBadge($email, static fn() => $user));
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        $request->getSession()->set('auth_provider', 'google');

        $user = $token->getUser();
        if ($user instanceof User) {
            $this->activityLogService->logLogin($user);
        }

        $roles = $user instanceof User ? $user->getRoles() : [];
        if (in_array('ROLE_ADMIN', $roles, true)) {
            return new RedirectResponse($this->urlGenerator->generate('app_admin_dashboard'));
        }

        if (in_array('ROLE_STAFF', $roles, true)) {
            return new RedirectResponse($this->urlGenerator->generate('app_staff_dashboard'));
        }

        return new RedirectResponse($this->urlGenerator->generate('app_landing'));
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        $request->getSession()->getFlashBag()->add(
            'error',
            $exception instanceof CustomUserMessageAuthenticationException
                ? $exception->getMessage()
                : 'Google sign-in failed. Please try again.'
        );

        return new RedirectResponse($this->urlGenerator->generate('app_login'));
    }
}
