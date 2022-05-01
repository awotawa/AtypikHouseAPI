<?php

namespace App\Repository;

use App\Entity\LodgingValue;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method LodgingValue|null find($id, $lockMode = null, $lockVersion = null)
 * @method LodgingValue|null findOneBy(array $criteria, array $orderBy = null)
 * @method LodgingValue[]    findAll()
 * @method LodgingValue[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LodgingValueRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LodgingValue::class);
    }

    // /**
    //  * @return LodgingValue[] Returns an array of LodgingValue objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?LodgingValue
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
