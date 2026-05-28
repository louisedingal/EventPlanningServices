<?php

namespace App\Controller;

use App\Entity\User;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/realtime')]
final class RealtimeTokenController extends AbstractController
{
    public function __construct(
        private readonly JWTTokenManagerInterface $jwtTokenManager,
    ) {
    }

    #[Route('/token', name: 'app_realtime_token', methods: ['GET'])]
    #[IsGranted('ROLE_USER')]
    public function token(#[CurrentUser] ?User $user): JsonResponse
    {
        if (!$user) {
            return $this->json(['message' => 'Unauthorized'], 401);
        }

        return $this->json([
            'token' => $this->jwtTokenManager->create($user),
        ]);
    }
}
