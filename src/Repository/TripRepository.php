<?php

namespace App\Repository;

use App\Entity\Trip;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Trip>
 *
 * @method Trip|null find($id, $lockMode = null, $lockVersion = null)
 * @method Trip|null findOneBy(array $criteria, array $orderBy = null)
 * @method Trip[]    findAll()
 * @method Trip[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TripRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Trip::class);
    }

    /**
     * @return Trip[] Returns an array of Sortie objects
     */
    public function personnalizedSearch($campus, $contains, $dateStartTime,
                                        $dateEndTime, $isOrganizer, $isRegisteredTo,
                                        $isNotRegisteredTo, $isPassed): array
    {
        $query = $this->createQueryBuilder('q');
        if($campus != null){
            # We already get the campus id passed ($campus = campus id)
            $query->andWhere('q.campus_id = :val')
            ->setParameter('val', $campus);
        }
        if($contains != null){
            $query->andWhere('q.name LIKE :val2')
            ->setParameter('val2', $contains);
        }
        if($dateStartTime != null){
        $query->andWhere('q.name LIKE :val2')
            ->setParameter('val2', $dateStartTime);
        }

        return $query
            ->getQuery()
            ->getResult()
        ;
    }

//    public function findOneBySomeField($value): ?Trip
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
