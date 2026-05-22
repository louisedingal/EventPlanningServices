<?php

namespace App\Repository;

use App\Entity\ActivityLog;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ActivityLog>
 */
class ActivityLogRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ActivityLog::class);
    }

    /**
     * Search and filter activity logs
     */
    public function search(?string $userEmail = null, ?string $action = null, ?\DateTimeImmutable $dateFrom = null, ?\DateTimeImmutable $dateTo = null, int $limit = 100): array
    {
        $qb = $this->createQueryBuilder('al')
            ->orderBy('al.createdAt', 'DESC');

        if ($userEmail) {
            $qb->andWhere('al.userEmail LIKE :userEmail')
               ->setParameter('userEmail', '%' . $userEmail . '%');
        }

        if ($action) {
            $qb->andWhere('al.action = :action')
               ->setParameter('action', $action);
        }

        if ($dateFrom) {
            $qb->andWhere('al.createdAt >= :dateFrom')
               ->setParameter('dateFrom', $dateFrom);
        }

        if ($dateTo) {
            $qb->andWhere('al.createdAt <= :dateTo')
               ->setParameter('dateTo', $dateTo);
        }

        $qb->setMaxResults($limit);

        return $qb->getQuery()->getResult();
    }

    /**
     * Get distinct user emails for filter dropdown
     */
    public function getDistinctUserEmails(): array
    {
        $result = $this->createQueryBuilder('al')
            ->select('DISTINCT al.userEmail')
            ->orderBy('al.userEmail', 'ASC')
            ->getQuery()
            ->getResult();

        return array_column($result, 'userEmail');
    }

    /**
     * Get distinct actions for filter dropdown
     */
    public function getDistinctActions(): array
    {
        $result = $this->createQueryBuilder('al')
            ->select('DISTINCT al.action')
            ->orderBy('al.action', 'ASC')
            ->getQuery()
            ->getResult();

        return array_column($result, 'action');
    }
}















