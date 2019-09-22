<?php

namespace App\Repository;

use App\Entity\Dinner;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Dinner|null find($id, $lockMode = null, $lockVersion = null)
 * @method Dinner|null findOneBy(array $criteria, array $orderBy = null)
 * @method Dinner[]    findAll()
 * @method Dinner[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DinnerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Dinner::class);
    }
}
