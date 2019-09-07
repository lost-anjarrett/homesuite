<?php

namespace App\Repository;

use App\Entity\Freezer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Freezer|null find($id, $lockMode = null, $lockVersion = null)
 * @method Freezer|null findOneBy(array $criteria, array $orderBy = null)
 * @method Freezer[]    findAll()
 * @method Freezer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FreezerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Freezer::class);
    }

    // /**
    //  * @return Freezer[] Returns an array of Freezer objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Freezer
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
