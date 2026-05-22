<?php

namespace App\Security;

use App\Entity\User;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;

class JWTAuthenticationSuccessHandler implements AuthenticationSuccessHandlerInterface
{
    public function __construct(
        private JWTTokenManagerInterface $jwtManager,
    ) {
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token): JsonResponse
    {
        /** @var User $user */
        $user = $token->getUser();

        $roles = $user->getRoles();
        $isStaffOrAdmin = in_array('ROLE_STAFF', $roles, true) || in_array('ROLE_ADMIN', $roles, true);

        // Customers must verify email; staff/admin are provisioned internally and may skip this gate.
        if (!$user->isVerified() && !$isStaffOrAdmin) {
            return new JsonResponse([
                'success' => false,
                'message' => 'Please verify your email address before logging in',
                'isVerified' => false,
                'verified' => false,
            ], 403);
        }

        $jwt = $this->jwtManager->create($user);

        return new JsonResponse([
            'token' => $jwt,
            'user' => [
                'id' => $user->getId(),
                'username' => $user->getUsername(),
                'email' => $user->getEmail(),
                'roles' => $user->getRoles(),
                'isVerified' => $user->isVerified(),
                'verified' => $user->isVerified(),
            ],
            'customerApi' => '/api/customer',
        ]);
    }
}

