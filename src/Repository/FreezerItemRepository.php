<?php

namespace App\Repository;

use App\Entity\FreezerItem;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method FreezerItem|null find($id, $lockMode = null, $lockVersion = null)
 * @method FreezerItem|null findOneBy(array $criteria, array $orderBy = null)
 * @method FreezerItem[]    findAll()
 * @method FreezerItem[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FreezerItemRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FreezerItem::class);
    }

    // /**
    //  * @return FreezerItem[] Returns an array of FreezerItem objects
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
    public function findOneBySomeField($value): ?FreezerItem
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
