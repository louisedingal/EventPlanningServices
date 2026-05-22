<?php

namespace App\Service;

use App\Entity\ActivityLog;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class ActivityLogService
{
    public function __construct(
        private EntityManagerInterface $entityManager
    ) {
    }

    /**
     * Log an activity
     */
    public function log(
        ?User $user,
        string $action,
        ?string $entityType = null,
        ?int $entityId = null,
        ?array $affectedData = null,
        ?string $description = null
    ): void {
        $log = new ActivityLog();
        
        if ($user) {
            $log->setUserEmail($user->getEmail());
            $roles = $user->getRoles();
            // Get the most specific role (prefer ROLE_ADMIN, then ROLE_STAFF, then ROLE_USER)
            $userRole = 'ROLE_USER';
            if (in_array('ROLE_ADMIN', $roles, true)) {
                $userRole = 'ROLE_ADMIN';
            } elseif (in_array('ROLE_STAFF', $roles, true)) {
                $userRole = 'ROLE_STAFF';
            }
            $log->setUserRole($userRole);
        } else {
            $log->setUserEmail('System');
            $log->setUserRole('SYSTEM');
        }

        $log->setAction($action);
        $log->setEntityType($entityType);
        $log->setEntityId($entityId);
        
        if ($affectedData !== null) {
            $log->setAffectedData(json_encode($affectedData, JSON_PRETTY_PRINT));
        }
        
        if ($description) {
            $log->setDescription($description);
        }

        $this->entityManager->persist($log);
        $this->entityManager->flush();
    }

    /**
     * Log a create action
     */
    public function logCreate(User $user, string $entityType, int $entityId, ?array $data = null, ?string $description = null): void
    {
        $this->log($user, 'Create', $entityType, $entityId, $data, $description);
    }

    /**
     * Log an update action
     */
    public function logUpdate(User $user, string $entityType, int $entityId, ?array $data = null, ?string $description = null): void
    {
        $this->log($user, 'Update', $entityType, $entityId, $data, $description);
    }

    /**
     * Log a delete action
     */
    public function logDelete(User $user, string $entityType, int $entityId, ?array $data = null, ?string $description = null): void
    {
        $this->log($user, 'Delete', $entityType, $entityId, $data, $description);
    }

    /**
     * Log a login action
     */
    public function logLogin(User $user): void
    {
        $this->log($user, 'Login', null, null, null, 'User logged in');
    }

    /**
     * Log a logout action
     */
    public function logLogout(User $user): void
    {
        $this->log($user, 'Logout', null, null, null, 'User logged out');
    }
}

