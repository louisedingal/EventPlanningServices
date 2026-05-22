<?php

namespace App\Security;

use App\Repository\UserRepository;
use App\Service\ActivityLogService;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Authenticator\AbstractLoginFormAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\CsrfTokenBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\RememberMeBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\SecurityRequestAttributes;
use Symfony\Component\Security\Http\Util\TargetPathTrait;

class LoginFormAuthenticator extends AbstractLoginFormAuthenticator
{
    use TargetPathTrait;

    public const LOGIN_ROUTE = 'app_login';

    public function __construct(
        private UrlGeneratorInterface $urlGenerator,
        private UserRepository $userRepository,
        private ActivityLogService $activityLogService
    ) {
    }

    public function authenticate(Request $request): Passport
    {
        $identifier = trim((string) $request->request->get('identifier', ''));

        $request->getSession()->set(SecurityRequestAttributes::LAST_USERNAME, $identifier);

        return new Passport(
            new UserBadge($identifier, function (string $userIdentifier) {
                $userIdentifier = trim($userIdentifier);

                $user = $this->userRepository->findOneBy(['email' => $userIdentifier]);
                if ($user) {
                    return $user;
                }

                $user = $this->userRepository->findOneBy(['username' => $userIdentifier]);
                if ($user) {
                    return $user;
                }

                throw new UserNotFoundException(sprintf('User "%s" not found.', $userIdentifier));
            }),
            new PasswordCredentials($request->request->get('password', '')),
            [
                new CsrfTokenBadge('authenticate', $request->request->get('_csrf_token')),
                new RememberMeBadge(),
            ]
        );
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        // Clear social-login marker when using password login.
        $request->getSession()->remove('auth_provider');

        // Check if user has admin role
        $user = $token->getUser();
        
        // Log login activity
        if ($user instanceof \App\Entity\User) {
            $this->activityLogService->logLogin($user);
        }
        
        $roles = $user->getRoles();
        if (in_array('ROLE_ADMIN', $roles, true)) {
            // Admin users go to dashboard
            return new RedirectResponse($this->urlGenerator->generate('app_admin_dashboard'));
        }
        
        if (in_array('ROLE_STAFF', $roles, true)) {
            // Staff users go to profile page
            return new RedirectResponse($this->urlGenerator->generate('app_admin_profile'));
        }

        // Regular users go to landing page
        return new RedirectResponse($this->urlGenerator->generate('app_landing'));
    }

    protected function getLoginUrl(Request $request): string
    {
        return $this->urlGenerator->generate(self::LOGIN_ROUTE);
    }
}

