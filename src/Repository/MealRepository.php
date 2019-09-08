<?php

namespace App\Repository;

use App\Entity\Meal;
use App\Entity\Menu;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Meal|null find($id, $lockMode = null, $lockVersion = null)
 * @method Meal|null findOneBy(array $criteria, array $orderBy = null)
 * @method Meal[]    findAll()
 * @method Meal[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MealRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Meal::class);
    }

    /**
     * @param Menu $menu
     * @param \DateInterval|null $interval
     *
     * @return array
     * @throws \Exception
     */
    public function getComingMealDates(Menu $menu, \DateTime $startingDate, \DateInterval $interval)
    {
        $endingDate = clone $startingDate;

        $result =  $this->createQueryBuilder('m')
            ->select('DISTINCT(m.date)')
            ->andWhere('m.menu = :val')
            ->setParameter('val', $menu)
            ->andWhere('m.date BETWEEN :from AND :to')
            ->setParameter('from', $startingDate)
            ->setParameter('to', $endingDate->add($interval))
            ->orderBy('m.date', 'ASC')
            ->getQuery()
            ->getResult()
        ;

        return reset($result);
    }

    /*
    public function findOneBySomeField($value): ?Meal
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
