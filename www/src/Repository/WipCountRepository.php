<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\WipCount;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method WipCount|null find($id, $lockMode = null, $lockVersion = null)
 * @method WipCount|null findOneBy(array $criteria, array $orderBy = null)
 * @method WipCount[]    findAll()
 * @method WipCount[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WipCountRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, WipCount::class);
    }

    // /**
    //  * @return WipCount[] Returns an array of WipCount objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('w.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?WipCount
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
