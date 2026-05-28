<?php

namespace App\Repository;

use App\Entity\EventRequest;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<EventRequest>
 */
class EventRequestRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EventRequest::class);
    }

    /**
     * Find pending requests (for admin dashboard)
     */
    public function findPending(): array
    {
        return $this->createQueryBuilder('er')
            ->where('er.status = :status')
            ->setParameter('status', 'pending')
            ->orderBy('er.createdAt', 'DESC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Find requests by user
     */
    public function findByUser($user): array
    {
        return $this->createQueryBuilder('er')
            ->where('er.requestedBy = :user')
            ->setParameter('user', $user)
            ->orderBy('er.createdAt', 'DESC')
            ->getQuery()
            ->getResult();
    }

    public function findPaid(): array
    {
        return $this->createQueryBuilder('er')
            ->where('er.paymentApprovedAt IS NOT NULL')
            ->orderBy('er.paymentApprovedAt', 'DESC')
            ->getQuery()
            ->getResult();
    }

    public function totalPaidAmount(): float
    {
        $raw = $this->createQueryBuilder('er')
            ->select('COALESCE(SUM(er.paymentAmount), 0)')
            ->where('er.paymentApprovedAt IS NOT NULL')
            ->getQuery()
            ->getSingleScalarResult();

        return (float) $raw;
    }
}

