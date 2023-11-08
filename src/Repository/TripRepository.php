<?php

namespace App\Repository;

use App\Entity\Trip;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\Persistence\ManagerRegistry;
use function Symfony\Component\Clock\now;

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
     * @return Trip[] Returns an array of Trip objects
     */
    public function personnalizedSearch($filter, $user): array
    {
        $query = $this->createQueryBuilder('t')
            ->innerJoin('t.users', 'tu')
            ->addSelect('tu')
            ->innerJoin('t.campus', 'tc');


        if($filter->getCampus() != null){
            $query->andWhere('t.campus = :val1')
            ->setParameter('val1', $filter->getCampus());
        }
        if($filter->getContains() != null){
            $query->andWhere('t.name LIKE :val2')
            ->setParameter('val2', '%'.$filter->getContains().'%');
        }
        if($filter->getDateStartTime() != null){
        $query->andWhere('t.dateStartTime >= :val3')
            ->setParameter('val3', $filter->getDateStartTime());
        }
        if($filter->getDateEndTime() != null){
            $query->andWhere('t.registrationDeadLine <= :val4')
                ->setParameter('val4', $filter->getDateEndTime());
        }
        if($filter->isOrganizer()){
            $query->andWhere('t.organizer = :val5')
                ->setParameter('val5', $user);
        }
        if($filter->isRegisteredTo()){
            $query->andWhere(':val6 member of t.users')
                ->setParameter('val6', $user);
        }
        if($filter->isNotRegisteredTo()){
            $query->andWhere(':val7 not member of t.users')
                ->setParameter('val7', $user);
        }
        if($filter->isPassed()){
            $query->andWhere('t.dateStartTime < :val8')
                ->setParameter('val8', now());
        }

        return $query
            ->getQuery()
            ->getResult()
        ;
    }
}
