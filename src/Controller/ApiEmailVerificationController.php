<?php

namespace App\Controller;

use App\Entity\User;
use App\Service\EmailVerificationService;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

#[Route('/api')]
class ApiEmailVerificationController extends AbstractController
{
    public function __construct(
        private EmailVerificationService $emailVerificationService,
        private LoggerInterface $logger,
    ) {
    }

    /**
     * Same verification as Web: POST JSON { "token" } or GET ?token= (e.g. deep links).
     */
    #[Route('/verify-email', name: 'api_verify_email', methods: ['GET', 'POST'])]
    public function verifyEmail(Request $request): JsonResponse
    {
        $token = $request->query->get('token');
        if ($request->isMethod('POST')) {
            $data = json_decode($request->getContent(), true);
            if ($token === null || $token === '') {
                $token = is_array($data) ? ($data['token'] ?? null) : null;
            }
        }

        $token = is_string($token) ? trim($token) : '';
        if ($token === '') {
            return $this->json([
                'success' => false,
                'message' => 'Verification token is required',
            ], 400);
        }

        $user = $this->emailVerificationService->verifyToken($token);

        if (!$user) {
            return $this->json([
                'success' => false,
                'message' => 'Invalid or expired verification token',
            ], 400);
        }

        return $this->json([
            'success' => true,
            'message' => 'Email verified successfully',
            'user' => [
                'id' => $user->getId(),
                'email' => $user->getEmail(),
                'isVerified' => $user->isVerified(),
            ],
        ], 200);
    }

    /**
     * Public: request a new link by email (unverified users cannot obtain JWT to call an authenticated resend).
     */
    #[Route('/resend-verification', name: 'api_resend_verification', methods: ['POST'])]
    public function resendVerification(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $email = is_array($data) ? trim((string) ($data['email'] ?? '')) : '';

        if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return $this->json([
                'success' => false,
                'message' => 'A valid email address is required',
            ], 400);
        }

        try {
            $this->emailVerificationService->resendVerificationLinkByEmail($email);
        } catch (\Throwable $e) {
            $this->logger->error('Resend verification email failed', [
                'exception' => $e->getMessage(),
                'email' => $email,
            ]);
        }

        return $this->json([
            'success' => true,
            'message' => 'If an account exists for this email and is not verified, we sent a verification message.',
        ], 200);
    }

    #[Route('/verification-status', name: 'api_verification_status', methods: ['GET'])]
    public function verificationStatus(#[CurrentUser] ?User $user): JsonResponse
    {
        if (!$user) {
            return $this->json([
                'success' => false,
                'message' => 'Authentication required',
            ], 401);
        }

        return $this->json([
            'success' => true,
            'isVerified' => $user->isVerified(),
            'email' => $user->getEmail(),
        ], 200);
    }
}
