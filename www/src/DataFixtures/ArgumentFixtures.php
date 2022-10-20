<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Argument;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ArgumentFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('de_CH');

        for ($i = 0; $i < 5; $i = $i + 2) {
            $argument = new Argument();
            $argument->setArgument($faker->text);
            $argument->setCampaign($this->getReference(CampaignFixture::CAMPAIGN_EID));

            $manager->persist($argument);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            CampaignFixture::class,
        ];
    }
}
