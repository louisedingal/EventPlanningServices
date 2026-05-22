<?php

namespace App\Controller;

use App\Service\EmailVerificationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class EmailVerificationController extends AbstractController
{
    #[Route('/verify-email/{token}', name: 'app_verify_email')]
    public function verifyUserEmail(
        string $token,
        EmailVerificationService $emailVerificationService
    ): Response {
        if (!$token) {
            $this->addFlash('error', 'Verification token is missing.');
            return $this->redirectToRoute('app_register');
        }

        $user = $emailVerificationService->verifyToken($token);

        if (!$user) {
            $this->addFlash('error', 'Invalid or expired verification token.');
            return $this->redirectToRoute('app_register');
        }

        $this->addFlash('success', 'Your email has been verified! You can now log in.');

        return $this->redirectToRoute('app_login');
    }

    #[Route('/resend-verification', name: 'app_resend_verification', methods: ['POST'])]
    public function resendVerification(
        Request $request,
        EmailVerificationService $emailVerificationService
    ): Response {
        if (!$this->isCsrfTokenValid('resend_verification', (string) $request->request->get('_token'))) {
            $this->addFlash('error', 'Invalid form submission. Please try again.');
            return $this->redirectToRoute('app_login');
        }

        $email = trim((string) $request->request->get('email', ''));

        try {
            $emailVerificationService->resendVerificationLinkByEmail($email);
        } catch (\Throwable) {
            // Same generic message either way
        }

        $this->addFlash(
            'info',
            'If an account exists for that email and is not verified, we sent a new verification link.'
        );

        return $this->redirectToRoute('app_login');
    }
}