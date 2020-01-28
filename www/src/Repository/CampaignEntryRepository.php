<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\CampaignEntry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CampaignEntry|null find($id, $lockMode = null, $lockVersion = null)
 * @method CampaignEntry|null findOneBy(array $criteria, array $orderBy = null)
 * @method CampaignEntry[]    findAll()
 * @method CampaignEntry[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CampaignEntryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CampaignEntry::class);
    }

    // /**
    //  * @return CampaignEntry[] Returns an array of CampaignEntry objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CampaignEntry
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
