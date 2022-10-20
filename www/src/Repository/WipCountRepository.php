<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\WipCount;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method WipCount|null find($id, $lockMode = null, $lockVersion = null)
 * @method WipCount|null findOneBy(array $criteria, array $orderBy = null)
 * @method WipCount[]    findAll()
 * @method WipCount[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WipCountRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, WipCount::class);
    }
}
