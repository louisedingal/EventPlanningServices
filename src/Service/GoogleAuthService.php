<?php

namespace App\Service;

use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Contracts\HttpClient\HttpClientInterface;

/**
 * Verifies Google ID tokens issued to the mobile app (web client ID).
 */
final class GoogleAuthService
{
    public function __construct(
        private HttpClientInterface $httpClient,
        #[Autowire('%env(GOOGLE_OAUTH_CLIENT_ID)%')]
        private string $googleClientId,
    ) {
    }

    /**
     * @return array{email: string, email_verified: bool, name: ?string, given_name: ?string, family_name: ?string}
     */
    public function verifyIdToken(string $idToken): array
    {
        $idToken = trim($idToken);
        if ($idToken === '') {
            throw new \InvalidArgumentException('Google ID token is required.');
        }

        $response = $this->httpClient->request(
            'GET',
            'https://oauth2.googleapis.com/tokeninfo',
            ['query' => ['id_token' => $idToken]]
        );

        if ($response->getStatusCode() !== 200) {
            throw new \RuntimeException('Invalid Google ID token.');
        }

        $payload = $response->toArray(false);

        $aud = (string) ($payload['aud'] ?? '');
        if ($aud !== $this->googleClientId) {
            throw new \RuntimeException('Google token audience does not match this application.');
        }

        $email = strtolower(trim((string) ($payload['email'] ?? '')));
        if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new \RuntimeException('Google account did not return a valid email.');
        }

        $emailVerified = filter_var($payload['email_verified'] ?? false, FILTER_VALIDATE_BOOLEAN);
        if (!$emailVerified) {
            throw new \RuntimeException('Your Google email address is not verified.');
        }

        return [
            'email' => $email,
            'email_verified' => true,
            'name' => isset($payload['name']) ? (string) $payload['name'] : null,
            'given_name' => isset($payload['given_name']) ? (string) $payload['given_name'] : null,
            'family_name' => isset($payload['family_name']) ? (string) $payload['family_name'] : null,
        ];
    }
}
