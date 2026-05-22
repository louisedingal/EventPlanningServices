<?php

namespace App\Repository;

use App\Entity\Theme;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Theme>
 */
class ThemeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Theme::class);
    }

    /**
     * Search themes by various criteria
     */
    public function search(?string $query = null, ?string $eventType = null): array
    {
        $qb = $this->createQueryBuilder('t');

        if ($query) {
            $qb->andWhere('t.name LIKE :query OR t.description LIKE :query')
               ->setParameter('query', '%' . $query . '%');
        }

        if ($eventType) {
            $qb->andWhere('t.eventType = :eventType')
               ->setParameter('eventType', $eventType);
        }

        return $qb->orderBy('t.name', 'ASC')
                  ->getQuery()
                  ->getResult();
    }

    /**
     * Themes created by staff/admin (for customer booking pickers).
     *
     * @return list<Theme>
     */
    public function findForCustomerCatalog(?string $eventType = null): array
    {
        $qb = $this->createQueryBuilder('t')
            ->orderBy('t.name', 'ASC');

        if ($eventType !== null && $eventType !== '') {
            $qb->andWhere('t.eventType = :eventType')
                ->setParameter('eventType', $eventType);
        }

        return $qb->getQuery()->getResult();
    }
}
