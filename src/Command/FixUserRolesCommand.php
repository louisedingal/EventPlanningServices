<?php

namespace App\Command;

use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:fix-user-roles',
    description: 'Fix fixture admin/staff roles and mark staff@gmail.com / admin@gmail.com as email-verified for API login',
)]
class FixUserRolesCommand extends Command
{
    public function __construct(
        private UserRepository $userRepository,
        private EntityManagerInterface $entityManager
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        
        $io->title('Fixing User Roles');
        
        // Define the role mappings
        $roleMappings = [
            'admin@gmail.com' => ['ROLE_ADMIN'],
            'staff@gmail.com' => ['ROLE_STAFF'],
        ];
        
        $updated = 0;
        $notFound = [];
        
        foreach ($roleMappings as $email => $roles) {
            $user = $this->userRepository->findOneBy(['email' => $email]);
            
            if ($user) {
                $currentRoles = $user->getRoles();
                // Remove ROLE_USER from current roles for comparison (it's auto-added)
                $currentRoles = array_filter($currentRoles, fn($role) => $role !== 'ROLE_USER');
                $currentRoles = array_values($currentRoles);
                
                // Check if roles need updating
                if ($currentRoles !== $roles) {
                    $user->setRoles($roles);
                    $this->entityManager->persist($user);
                    $io->success(sprintf('Updated %s: %s -> %s', $email, json_encode($currentRoles), json_encode($roles)));
                    $updated++;
                } else {
                    $io->info(sprintf('%s already has correct roles: %s', $email, json_encode($roles)));
                }

                // Fixture admin/staff must be email-verified so JWT login matches web expectations.
                if (!$user->isVerified()) {
                    $user->setIsVerified(true);
                    $user->setVerificationToken(null);
                    $this->entityManager->persist($user);
                    $io->success(sprintf('Marked %s as email-verified (staff/admin fixture).', $email));
                    $updated++;
                }
            } else {
                $notFound[] = $email;
            }
        }
        
        // Also fix any users with empty roles array that should be regular users
        // (This ensures they have [] which means ROLE_USER by default)
        $allUsers = $this->userRepository->findAll();
        foreach ($allUsers as $user) {
            $email = $user->getEmail();
            // Skip users we already processed
            if (isset($roleMappings[$email])) {
                continue;
            }
            
            // If user has empty roles or null, ensure it's set to empty array
            $roles = $user->getRoles();
            $roles = array_filter($roles, fn($role) => $role !== 'ROLE_USER');
            $roles = array_values($roles);
            
            if (!empty($roles)) {
                // User has some custom roles, keep them
                continue;
            }
            
            // Ensure empty array for regular users
            $user->setRoles([]);
            $this->entityManager->persist($user);
        }
        
        if ($updated > 0) {
            $this->entityManager->flush();
            $io->success(sprintf('Successfully updated %d user(s)!', $updated));
        } else {
            $io->info('No users needed updating. All roles are correct.');
        }
        
        if (!empty($notFound)) {
            $io->warning(sprintf('The following users were not found: %s', implode(', ', $notFound)));
        }
        
        return Command::SUCCESS;
    }
}
