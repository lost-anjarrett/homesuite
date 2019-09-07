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
     * @return Meal[] Returns an array of Meal objects
     * @throws \Exception
     */
    public function getComingMeals(Menu $menu, \DateInterval $interval = null)
    {
        if ($interval !== null) {
            // TODO
            throw new \Exception('Ceci est un TODO enfoiré ! L\'intervalle n\'est pas géré');
        }

        return $this->createQueryBuilder('m')
            ->andWhere('m.menu = :val')
            ->setParameter('val', $menu)
            ->andWhere('m.date > :date')
            ->setParameter('date', new \DateTime('today'))
            ->orderBy('m.date', 'ASC')
            ->setMaxResults(21)
            ->getQuery()
            ->getResult()
        ;
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
