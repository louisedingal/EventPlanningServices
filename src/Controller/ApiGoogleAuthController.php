<?php

namespace App\Controller;

use App\Entity\User;
use App\Security\UserChecker;
use App\Service\ActivityLogService;
use App\Service\GoogleAuthService;
use App\Service\GoogleUserProvisioner;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAccountStatusException;

#[Route('/api')]
final class ApiGoogleAuthController extends AbstractController
{
    public function __construct(
        private GoogleAuthService $googleAuthService,
        private GoogleUserProvisioner $googleUserProvisioner,
        private JWTTokenManagerInterface $jwtManager,
        private UserChecker $userChecker,
        private ActivityLogService $activityLogService,
    ) {
    }

    /**
     * Mobile Google Sign-In: exchange a Google ID token for a JWT.
     *
     * Body: { "idToken": "<from @react-native-google-signin/google-signin>" }
     */
    #[Route('/google', name: 'api_google_auth', methods: ['POST'])]
    public function authenticate(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        if (!is_array($data)) {
            return $this->json([
                'success' => false,
                'message' => 'Invalid JSON body',
            ], 400);
        }

        $idToken = trim((string) ($data['idToken'] ?? $data['id_token'] ?? ''));
        if ($idToken === '') {
            return $this->json([
                'success' => false,
                'message' => 'Google ID token is required',
            ], 400);
        }

        try {
            $profile = $this->googleAuthService->verifyIdToken($idToken);
            $user = $this->googleUserProvisioner->provision($profile);

            try {
                $this->userChecker->checkPreAuth($user);
            } catch (CustomUserMessageAccountStatusException $e) {
                return $this->json([
                    'success' => false,
                    'message' => $e->getMessage(),
                ], 403);
            }

            $this->activityLogService->logLogin($user);

            $jwt = $this->jwtManager->create($user);

            return $this->json([
                'token' => $jwt,
                'user' => $this->serializeUser($user),
                'customerApi' => '/api/customer',
            ]);
        } catch (\InvalidArgumentException|\RuntimeException $e) {
            return $this->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    private function serializeUser(User $user): array
    {
        return [
            'id' => $user->getId(),
            'username' => $user->getUsername(),
            'email' => $user->getEmail(),
            'roles' => $user->getRoles(),
            'isVerified' => $user->isVerified(),
            'verified' => $user->isVerified(),
        ];
    }
}
