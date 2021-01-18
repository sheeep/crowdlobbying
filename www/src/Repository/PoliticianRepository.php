<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Campaign;
use App\Entity\Commission;
use App\Entity\Politician;
use App\Entity\PoliticianType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Politician|null find($id, $lockMode = null, $lockVersion = null)
 * @method Politician|null findOneBy(array $criteria, array $orderBy = null)
 * @method Politician[]    findAll()
 * @method Politician[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PoliticianRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
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
    public function findByCommissions(Collection $commissions): array
    {
        $politicians = [];

        /** @var Commission $commission */
        foreach ($commissions as $commission) {
            $politicians += $commission->getMembers()->toArray();
        }

        return $politicians;
    }

    /** @return Politician[] */
    public function findByCampaign(Campaign $campaign): array
    {
        $byTypeAndReqions = $this->findByTypeAndRegions($campaign->getPoliticianType(), $campaign->getRegions());
        $byCommissions = $this->findByCommissions($campaign->getCommissions());

        $politicians = $byTypeAndReqions;

        if (\count($byCommissions) > 0) {
            $politicians = $byCommissions;
        }

        uasort($politicians, static function (Politician $first, Politician $second) {
            return $first->getLastName() > $second->getLastName() ? 1 : -1;
        });

        return $politicians;
    }
}
