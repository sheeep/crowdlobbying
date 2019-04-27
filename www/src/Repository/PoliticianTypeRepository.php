<?php

namespace App\Repository;

use App\Entity\PoliticianType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method PoliticianType|null find($id, $lockMode = null, $lockVersion = null)
 * @method PoliticianType|null findOneBy(array $criteria, array $orderBy = null)
 * @method PoliticianType[]    findAll()
 * @method PoliticianType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PoliticianTypeRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, PoliticianType::class);
    }

    // /**
    //  * @return PoliticianType[] Returns an array of PoliticianType objects
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
    public function findOneBySomeField($value): ?PoliticianType
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
