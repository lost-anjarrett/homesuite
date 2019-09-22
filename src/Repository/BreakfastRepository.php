<?php

namespace App\Repository;

use App\Entity\Breakfast;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Breakfast|null find($id, $lockMode = null, $lockVersion = null)
 * @method Breakfast|null findOneBy(array $criteria, array $orderBy = null)
 * @method Breakfast[]    findAll()
 * @method Breakfast[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BreakfastRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Breakfast::class);
    }
}
