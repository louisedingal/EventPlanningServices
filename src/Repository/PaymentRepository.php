<?php

namespace App\Repository;

use App\Entity\Payment;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Payment>
 */
class PaymentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Payment::class);
    }

    /**
     * @return list<Payment>
     */
    public function findByUser(User $user): array
    {
        return $this->createQueryBuilder('p')
            ->innerJoin('p.eventRequest', 'er')
            ->addSelect('er')
            ->where('p.user = :user')
            ->setParameter('user', $user)
            ->orderBy('p.createdAt', 'DESC')
            ->getQuery()
            ->getResult();
    }

    /**
     * @return list<Payment>
     */
    public function findAllApproved(): array
    {
        return $this->createQueryBuilder('p')
            ->innerJoin('p.eventRequest', 'er')
            ->addSelect('er')
            ->innerJoin('p.user', 'u')
            ->addSelect('u')
            ->where('p.status = :status')
            ->setParameter('status', Payment::STATUS_APPROVED)
            ->orderBy('p.createdAt', 'DESC')
            ->getQuery()
            ->getResult();
    }

    public function totalApprovedAmount(): float
    {
        $raw = $this->createQueryBuilder('p')
            ->select('COALESCE(SUM(p.amount), 0)')
            ->where('p.status = :status')
            ->setParameter('status', Payment::STATUS_APPROVED)
            ->getQuery()
            ->getSingleScalarResult();

        return (float) $raw;
    }
}
