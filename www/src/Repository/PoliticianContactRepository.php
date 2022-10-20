<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\PoliticianContact;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PoliticianContact|null find($id, $lockMode = null, $lockVersion = null)
 * @method PoliticianContact|null findOneBy(array $criteria, array $orderBy = null)
 * @method PoliticianContact[]    findAll()
 * @method PoliticianContact[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PoliticianContactRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PoliticianContact::class);
    }
}
