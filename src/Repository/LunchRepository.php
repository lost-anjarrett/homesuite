<?php

namespace App\Repository;

use App\Entity\Lunch;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Lunch|null find($id, $lockMode = null, $lockVersion = null)
 * @method Lunch|null findOneBy(array $criteria, array $orderBy = null)
 * @method Lunch[]    findAll()
 * @method Lunch[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LunchRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Lunch::class);
    }
}
