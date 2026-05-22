<?php

namespace App\Repository;

use App\Entity\Event;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Event>
 */
class EventRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Event::class);
    }

    /**
     * Search events by various criteria
     */
    public function search(?string $query = null, ?string $eventType = null, ?string $venue = null): array
    {
        $qb = $this->createQueryBuilder('e');

        if ($query) {
            $qb->andWhere('e.customerName LIKE :query OR e.theme LIKE :query OR e.venue LIKE :query')
               ->setParameter('query', '%' . $query . '%');
        }

        if ($eventType) {
            $qb->andWhere('e.eventType = :eventType')
               ->setParameter('eventType', $eventType);
        }

        if ($venue) {
            $qb->andWhere('e.venue LIKE :venue')
               ->setParameter('venue', '%' . $venue . '%');
        }

        return $qb->orderBy('e.eventDate', 'DESC')
                  ->getQuery()
                  ->getResult();
    }

    /**
     * Search events by creator (for staff to see only their own records)
     */
    public function searchByCreator($creator, ?string $query = null, ?string $eventType = null, ?string $venue = null): array
    {
        $qb = $this->createQueryBuilder('e')
            ->where('e.createdBy = :creator')
            ->setParameter('creator', $creator);

        if ($query) {
            $qb->andWhere('e.customerName LIKE :query OR e.theme LIKE :query OR e.venue LIKE :query')
               ->setParameter('query', '%' . $query . '%');
        }

        if ($eventType) {
            $qb->andWhere('e.eventType = :eventType')
               ->setParameter('eventType', $eventType);
        }

        if ($venue) {
            $qb->andWhere('e.venue LIKE :venue')
               ->setParameter('venue', '%' . $venue . '%');
        }

        return $qb->orderBy('e.eventDate', 'DESC')
                  ->getQuery()
                  ->getResult();
    }

    //    /**
    //     * @return Event[] Returns an array of Event objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('e')
    //            ->andWhere('e.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('e.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Event
    //    {
    //        return $this->createQueryBuilder('e')
    //            ->andWhere('e.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
