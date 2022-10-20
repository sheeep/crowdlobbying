<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Campaign;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Campaign|null find($id, $lockMode = null, $lockVersion = null)
 * @method Campaign|null findOneBy(array $criteria, array $orderBy = null)
 * @method Campaign[]    findAll()
 * @method Campaign[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CampaignRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Campaign::class);
    }

    public function findActiveCampaigns(\DateTime $dateTime = null): array
    {
        if (!$dateTime) {
            $dateTime = new \DateTime();
        }

        return $this->createQueryBuilder('e')
            ->andWhere('e.start <= :dateTime')
            ->andWhere('e.end >= :dateTime')
            ->setParameter('dateTime', $dateTime)
            ->orderBy('e.id', 'ASC')
            ->getQuery()
            ->execute();
    }
}
