<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Campaign;
use App\Entity\Party;
use App\Entity\Politician;
use App\Entity\PoliticianContact;
use App\Entity\PoliticianType;
use App\Entity\Region;
use App\Entity\WipCount;
use App\Repository\PartyRepository;
use App\Repository\RegionRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class PoliticianFixture extends Fixture implements DependentFixtureInterface
{
    protected $projectDir;

    public function __construct(string $projectDir)
    {
        $this->projectDir = $projectDir;
    }

    public function load(ObjectManager $manager): void
    {
        if (file_exists($this->projectDir . '/import/politicians.csv') && false !== ($fp = fopen($this->projectDir . '/import/politicians.csv', 'r'))) {
            $line = 0;
            $languages = [
                'd' => 'de',
                'f' => 'fr',
                'i' => 'it',
                'e' => 'en',
            ];
            $faker = Factory::create('de_CH');

            /** @var RegionRepository $regionRepo */
            $regionRepo = $manager->getRepository(Region::class);

            /** @var PartyRepository $partyRepo */
            $partyRepo = $manager->getRepository(Party::class);

            /** @var PoliticianType $politicianType */
            $politicianType = $this->getReference(PoliticianTypeFixture::POLITICIAN_TYPE_SR);

            /** @var Campaign $campaign */
            $campaign = $this->getReference(CampaignFixture::CAMPAIGN_EID);

            while (false !== ($row = fgetcsv($fp, 0, ';'))) {
                // the ";" because fuck Excel, that uses ";" instead of "," in the German version
                ++$line;
                if (1 === $line) {
                    continue;
                }

                $entry = [
                    'lang' => $row[1] ?? 'd',
                    'region' => $row[2] ?? 'ZH',
                    'party' => $row[3] ?? 'Parteilos',
                    'twitter' => $row[4] ?? '',
                    'salutation' => $row[5] ?? '',
                    'prename' => $row[6] ?? '',
                    'lastname' => $row[7] ?? '',
                    'postSalutation' => $row[8] ?? '',
                    'company' => $row[9] ?? '',
                    'address1' => $row[10] ?? '',
                    'address2' => $row[11] ?? '',
                    'zip' => $row[12] ?? '',
                    'city' => $row[13] ?? '',
                    'email' => $row[14] ?? '',
                    'mobile' => $row[15] ?? '',
                    'phone' => $row[16] ?? '',
                    'fax' => $row[17] ?? '',
                    'website' => $row[18] ?? '',
                ];

                $region = $regionRepo->findOneBy(['short' => $entry['region']]);
                $party = $partyRepo->findOneBy(['short' => $entry['party']]);

                if ($region && $party) {
                    $politician = new Politician();
                    $politician->setName($entry['prename'] . ' ' . $entry['lastname']);
                    $politician->setLastname($entry['lastname']);
                    $politician->setLang($languages[($entry['lang'])] ?? 'de');
                    $politician->setSince($faker->dateTimeThisDecade);
                    $politician->setRegion($region);
                    $politician->setParty($party);
                    $politician->setPoliticianType($politicianType);
                    $politician->setTwitter($entry['twitter']);
                    $politician->setImageFile($this->getImage());

                    $contact = new PoliticianContact();
                    $contact->setSalutation($entry['salutation']);
                    $contact->setPrename($entry['prename']);
                    $contact->setLastname($entry['lastname']);
                    $contact->setPostSalutation($entry['postSalutation']);
                    $contact->setCompany($entry['company']);
                    $contact->setAddress1($entry['address1']);
                    $contact->setAddress2($entry['address2']);
                    $contact->setZip((int) $entry['zip']);
                    $contact->setCity($entry['city']);
                    $contact->setEmail($entry['email']);
                    $contact->setMobile($entry['mobile']);
                    $contact->setPhone($entry['phone']);
                    $contact->setFax($entry['fax']);
                    $contact->setWebsite($entry['website']);

                    $manager->persist($contact);
                    $politician->setContact($contact);

                    $manager->persist($politician);

                    $wipCount = new WipCount();
                    $wipCount->setStatus(random_int(WipCount::WIP_COUNT_TYPE_UNKNOWN, WipCount::WIP_COUNT_TYPE_NO));
                    $wipCount->setCampaign($campaign);
                    $wipCount->setPolitician($politician);

                    $manager->persist($wipCount);
                } else {
                    var_dump('Error on line ' . $line . ':', $entry);
                }
            }
            fclose($fp);
        }
        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            CampaignFixture::class,
            PoliticianTypeFixture::class,
            PartyFixture::class,
        ];
    }

    private function getImage(): UploadedFile
    {
        $image = sprintf('%s/Resources/politician-image.png', __DIR__);

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
