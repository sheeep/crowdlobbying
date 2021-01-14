<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\PersonArgument;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PersonArgument|null find($id, $lockMode = null, $lockVersion = null)
 * @method PersonArgument|null findOneBy(array $criteria, array $orderBy = null)
 * @method PersonArgument[]    findAll()
 * @method PersonArgument[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PersonArgumentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PersonArgument::class);
    }
}
