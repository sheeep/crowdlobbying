<?php

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
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class PoliticianFixture extends Fixture implements DependentFixtureInterface
{
    protected $projectDir;

    public function __construct(string $projectDir)
    {
        $this->projectDir = $projectDir;
    }

    public function load(ObjectManager $manager)
    {
        if (file_exists($this->projectDir . '/import/politicians.csv') && ($fp = fopen($this->projectDir . '/import/politicians.csv', "r")) !== false) {
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
            while (($row = fgetcsv($fp, 0, ";")) !== FALSE) {
                // the ";" because fuck Excel, that uses ";" instead of "," in the German version
                $line++;
                if ($line == 1) { continue; }

                $entry = [
                    'lang' => $row[1] ?? 'd',
                    'region' => $row[2] ?? 'ZH',
                    'party' => $row[3] ?? 'Parteilos',
                    'salutation' => $row[4] ?? '',
                    'prename' => $row[5] ?? '',
                    'lastname' => $row[6] ?? '',
                    'postSalutation' => $row[7] ?? '',
                    'company' => $row[8] ?? '',
                    'address1' => $row[9] ?? '',
                    'address2' => $row[10] ?? '',
                    'zip' => $row[11] ?? '',
                    'city' => $row[12] ?? '',
                    'email' => $row[13] ?? '',
                    'mobile' => $row[14] ?? '',
                    'phone' => $row[15] ?? '',
                    'fax' => $row[16] ?? '',
                    'website' => $row[17] ?? '',
                ];

                $region = $regionRepo->findOneBy(['short' => $entry['region']]);
                $party = $partyRepo->findOneBy(['short' => $entry['party']]);
                if ($region && $party) {
                    $politician = new Politician();
                    $politician->setName($entry['prename'] . ' ' . $entry['lastname']);
                    $politician->setLang($languages[($entry['lang'])] ?? 'de');
                    $politician->setSince($faker->dateTimeThisDecade);
                    $politician->setRegion($region);
                    $politician->setParty($party);
                    $politician->setPoliticianType($politicianType);

                    $contact = new PoliticianContact();
                    $contact->setSalutation($entry['salutation']);
                    $contact->setPrename($entry['prename']);
                    $contact->setLastname($entry['lastname']);
                    $contact->setPostSalutation($entry['postSalutation']);
                    $contact->setCompany($entry['company']);
                    $contact->setAddress1($entry['address1']);
                    $contact->setAddress2($entry['address2']);
                    $contact->setZip($entry['zip']);
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
                    $wipCount->setStatus(rand(WipCount::WIP_COUNT_TYPE_UNKNOWN, WipCount::WIP_COUNT_TYPE_NO));
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
}
