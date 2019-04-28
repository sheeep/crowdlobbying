<?php

namespace App\Repository;

use App\Entity\Campaign;
use App\Entity\Politician;
use App\Entity\PoliticianType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Politician|null find($id, $lockMode = null, $lockVersion = null)
 * @method Politician|null findOneBy(array $criteria, array $orderBy = null)
 * @method Politician[]    findAll()
 * @method Politician[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PoliticianRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Politician::class);
    }

    /** @return Politician[] */
    public function findByTypeAndRegions(PoliticianType $politicianType, $regions): array
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.politicianType = :politicianType')
            ->setParameter('politicianType', $politicianType)
            ->andWhere('e.region IN (:regions)')
            ->setParameter('regions', $regions)
            ->orderBy('e.name', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /** @return Politician[] */
    public function findByCampaign(Campaign $campaign): array
    {
        return $this->findByTypeAndRegions($campaign->getPoliticianType(), $campaign->getRegions());
    }

    // /**
    //  * @return Politician[] Returns an array of Politician objects
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
    public function findOneBySomeField($value): ?Politician
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
