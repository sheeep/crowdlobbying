<?php

namespace App\DataFixtures;

use App\Entity\Argument;
use App\Entity\Campaign;
use App\Entity\CampaignEntry;
use App\Entity\Person;
use App\Entity\Politician;
use App\Repository\PersonRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('de_CH');
        /** @var PersonRepository $personRepo */
        $personRepo = $manager->getRepository(Person::class);
        $politicianRepo = $manager->getRepository(Politician::class);
        foreach ($politicianRepo->findBy(['politicianType' => $this->getReference(PoliticianTypeFixture::POLITICIAN_TYPE_SR)]) as $politician) {
            /** @var Politician $politician */
            $politician = $politicianRepo->find($politician->getId());
            /**
             * Arguments and campaign need to be loaded inside the loop, as we'll clear the EM at the end of each itteration
             */
            /** @var Argument[] $arguments */
            $arguments = $manager->getRepository(Argument::class)->findAll();
            $argLen = count($arguments);
            /** @var Campaign $campaign */
            $campaign = $this->getReference(CampaignFixture::CAMPAIGN_EID);
            $len = rand(50, 250);
            for ($i=0; $i<$len; $i++) {
                $email = $faker->email;
                $person = $personRepo->findOneBy(['email' => $email]);
                if (!$person) {
                    $person = new Person();
                    $person->setEmail($email);
                    $person->setFirstname($faker->firstName);
                    $person->setLastname($faker->lastName);
                    $city = $faker->city;
                    if (!$city) { $city = 'Zürich'; }
                    $person->setCity($city);

                    $manager->persist($person);
                }

                $campaignEntry = new CampaignEntry();
                $campaignEntry->setOptInInformation((bool) (rand(0, 10) < 5));
                $campaignEntry->setPerson($person);
                $campaignEntry->setCampaign($campaign);
                $campaignEntry->setPreparedArgument($arguments[(rand(0, 77) % $argLen)]);
                $campaignEntry->setPolitician($politician);

                $manager->persist($campaignEntry);
            }
            $manager->flush();
            $manager->clear();
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            ArgumentFixtures::class,
            CampaignFixture::class,
            PoliticianTypeFixture::class,
        ];
    }
}
