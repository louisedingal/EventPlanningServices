<?php

namespace App\Security;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Http\Authorization\AccessDeniedHandlerInterface;

class AccessDeniedHandler implements AccessDeniedHandlerInterface
{
    public function __construct(
        private UrlGeneratorInterface $urlGenerator,
        private TokenStorageInterface $tokenStorage,
        private AuthorizationCheckerInterface $authorizationChecker
    ) {
    }

    public function handle(Request $request, AccessDeniedException $accessDeniedException): ?Response
    {
        $token = $this->tokenStorage->getToken();
        $user = $token ? $token->getUser() : null;
        
        // Check if user is authenticated
        if ($user && $user !== 'anon.') {
            // Check if user is admin
            if ($this->authorizationChecker->isGranted('ROLE_ADMIN')) {
                // Admin users: redirect to admin dashboard with error message
                $request->getSession()->getFlashBag()->add('error', 'You do not have permission to access this page.');
                return new RedirectResponse($this->urlGenerator->generate('app_admin_dashboard'));
            } elseif ($this->authorizationChecker->isGranted('ROLE_STAFF')) {
                // Staff users: redirect to events page (staff-accessible) with error message
                $request->getSession()->getFlashBag()->add('error', 'Access denied. This page is restricted to administrators only.');
                return new RedirectResponse($this->urlGenerator->generate('app_event_index'));
            }
        }
        
        // Unauthenticated users: redirect to landing page
        $request->getSession()->getFlashBag()->add('error', 'You do not have permission to access this page.');
        return new RedirectResponse($this->urlGenerator->generate('app_landing'));
    }
}

