<?php

namespace App\Service;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

/**
 * Finds or creates a local user from a verified Google profile (same rules as web Google login).
 */
final class GoogleUserProvisioner
{
    public function __construct(
        private UserRepository $userRepository,
        private EntityManagerInterface $entityManager,
        private UserPasswordHasherInterface $passwordHasher,
    ) {
    }

    /**
     * @param array{email: string, name: ?string, given_name: ?string, family_name: ?string} $profile
     */
    public function provision(array $profile): User
    {
        $email = $profile['email'];
        $user = $this->userRepository->findOneBy(['email' => $email]);

        if (!$user instanceof User) {
            $user = new User();
            $user->setEmail($email);
            $user->setRoles(['ROLE_USER']);
            $user->setUsername($this->uniqueUsernameFromEmail($email));

            if (!empty($profile['given_name'])) {
                $user->setName($profile['given_name']);
            }
            if (!empty($profile['family_name'])) {
                $user->setLastName($profile['family_name']);
            }

            $randomPassword = bin2hex(random_bytes(16));
            $user->setPassword($this->passwordHasher->hashPassword($user, $randomPassword));

            $this->entityManager->persist($user);
        }

        if (!$user->isVerified()) {
            $user->setIsVerified(true);
        }
        if ($user->getVerificationToken() !== null) {
            $user->setVerificationToken(null);
        }

        $this->entityManager->flush();

        return $user;
    }

    private function uniqueUsernameFromEmail(string $email): string
    {
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

        return $candidate;
    }
}
