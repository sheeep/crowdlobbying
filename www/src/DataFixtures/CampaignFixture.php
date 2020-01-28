<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Campaign;
use App\Entity\Region;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class CampaignFixture extends Fixture implements DependentFixtureInterface
{
    public const CAMPAIGN_EID = 'eid';

    public function load(ObjectManager $manager): void
    {
        $campaign = new Campaign();
        $campaign->setName('E-ID');
        $campaign->setStart(new \DateTime('2019-04-25'));
        $campaign->setEnd(new \DateTime('2019-05-01'));
        foreach ($manager->getRepository(Region::class)->findAll() as $region) {
            /* @var Region $region */
            $campaign->addRegion($region);
        }
        $campaign->setPoliticianType($this->getReference(PoliticianTypeFixture::POLITICIAN_TYPE_SR));
        $manager->persist($campaign);

        $manager->flush();

        $this->addReference(self::CAMPAIGN_EID, $campaign);
    }

    public function getDependencies(): array
    {
        return [
            RegionFixture::class,
            PoliticianTypeFixture::class,
        ];
    }
}
