<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Campaign;
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

    public function findByCampaign(Campaign $campaign, bool $confirmed = true, int $limit = null, $locale = null)
    {
        $qb = $this->createQueryBuilder('ce')
            ->andWhere('ce.campaign = :campaign')
            ->setParameter('campaign', $campaign)
        ;

        if ($locale) {
            $qb
                ->leftJoin('ce.personArgument', 'pa')
                ->andWhere('pa.locale = :locale OR pa.locale IS NULL')
                ->setParameter('locale', $locale)
            ;
        }

        if ($confirmed) {
            $qb
                ->andWhere('ce.confirmed = :confirmed')
                ->setParameter('confirmed', $confirmed)
            ;
        }

        if ($limit) {
            $qb->setMaxResults($limit);
        }

        return $qb
            ->addOrderBy('ce.createdAt', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }
}
