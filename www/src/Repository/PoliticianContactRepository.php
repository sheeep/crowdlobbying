<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\PoliticianContact;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method PoliticianContact|null find($id, $lockMode = null, $lockVersion = null)
 * @method PoliticianContact|null findOneBy(array $criteria, array $orderBy = null)
 * @method PoliticianContact[]    findAll()
 * @method PoliticianContact[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PoliticianContactRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, PoliticianContact::class);
    }

    // /**
    //  * @return PoliticianContact[] Returns an array of PoliticianContact objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PoliticianContact
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
