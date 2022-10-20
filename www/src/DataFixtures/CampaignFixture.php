<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Campaign;
use App\Entity\Region;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\File\UploadedFile;

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

        $imageDe = $this->getImage();
        $imageFr = $this->getImage();
        $imageBackground = $this->getImage();

        $campaign->setOgImageFileDe($imageDe);
        $campaign->setOgImageFileFr($imageFr);
        $campaign->setHeroBackgroundFile($imageBackground);

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

    private function getImage(): UploadedFile
    {
        $image = sprintf('%s/Resources/campaign-image.png', __DIR__);

        /** @var string $imageCopy */
        $imageCopy = tempnam(sys_get_temp_dir(), '_upload_fixture');
        copy($image, $imageCopy);

        return new UploadedFile(
            $imageCopy,
            'campaign-image.png',
            'image/png',
            null,
            true,
        );
    }
}
