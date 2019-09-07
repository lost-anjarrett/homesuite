<?php

namespace App\Repository;

use App\Entity\FreezerItemCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method FreezerItemCategory|null find($id, $lockMode = null, $lockVersion = null)
 * @method FreezerItemCategory|null findOneBy(array $criteria, array $orderBy = null)
 * @method FreezerItemCategory[]    findAll()
 * @method FreezerItemCategory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FreezerItemCategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FreezerItemCategory::class);
    }

    // /**
    //  * @return FreezerItemCategory[] Returns an array of FreezerItemCategory objects
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
    public function findOneBySomeField($value): ?FreezerItemCategory
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
