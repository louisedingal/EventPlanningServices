<?php

namespace App\Controller;

use App\Security\UserChecker;
use App\Service\ActivityLogService;
use App\Service\GoogleUserProvisioner;
use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAccountStatusException;

/**
 * Google OAuth for the Dingal mobile app via system browser (no native Google Sign-In SDK).
 */
final class ApiGoogleMobileOAuthController extends AbstractController
{
    public function __construct(
        private ClientRegistry $clientRegistry,
        private GoogleUserProvisioner $googleUserProvisioner,
        private JWTTokenManagerInterface $jwtManager,
        private UserChecker $userChecker,
        private ActivityLogService $activityLogService,
    ) {
    }

    #[Route('/api/google/mobile', name: 'api_google_mobile_start', methods: ['GET'])]
    public function start(): RedirectResponse
    {
        return $this->clientRegistry
            ->getClient('google_mobile')
            ->redirect(
                ['email', 'profile'],
                ['prompt' => 'select_account']
            );
    }

    #[Route('/api/google/mobile/callback', name: 'api_google_mobile_callback', methods: ['GET'])]
    public function callback(Request $request): RedirectResponse
    {
        if ($request->query->has('error')) {
            return $this->redirectToApp([
                'error' => 'cancelled',
                'message' => 'Google sign-in was cancelled.',
            ]);
        }

        try {
            $client = $this->clientRegistry->getClient('google_mobile');
            $accessToken = $client->getAccessToken();
            $googleUser = $client->fetchUserFromToken($accessToken);

            $email = strtolower(trim((string) $googleUser->getEmail()));
            if ($email === '') {
                return $this->redirectToApp([
                    'error' => 'no_email',
                    'message' => 'Google did not return an email address.',
                ]);
            }

            $user = $this->googleUserProvisioner->provision([
                'email' => $email,
                'name' => method_exists($googleUser, 'getFirstName') ? $googleUser->getFirstName() : null,
                'given_name' => method_exists($googleUser, 'getFirstName') ? $googleUser->getFirstName() : null,
                'family_name' => method_exists($googleUser, 'getLastName') ? $googleUser->getLastName() : null,
            ]);

            try {
                $this->userChecker->checkPreAuth($user);
            } catch (CustomUserMessageAccountStatusException $e) {
                return $this->redirectToApp([
                    'error' => 'account_blocked',
                    'message' => $e->getMessage(),
                ]);
            }

            $this->activityLogService->logLogin($user);
            $jwt = $this->jwtManager->create($user);

            return $this->redirectToApp([
                'token' => $jwt,
                'email' => $user->getEmail(),
                'username' => $user->getUsername() ?? '',
            ]);
        } catch (\Throwable $e) {
            return $this->redirectToApp([
                'error' => 'oauth_failed',
                'message' => 'Google sign-in failed. Please try again.',
            ]);
        }
    }

    private function redirectToApp(array $params): RedirectResponse
    {
        return new RedirectResponse('dingal://oauth?' . http_build_query($params));
    }
}
