<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Party;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class PartyFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $parties = [
            'CVP' => 'Christlichdemokratische Volkspartei',
            'FDP' => 'FDP.Die Liberalen',
            'SP' => 'Sozialdemokratische Partei der Schweiz',
            'SVP' => 'Schweizerische Volkspartei',
            'GPS' => 'Grüne Partei der Schweiz',
            'BDP' => 'Bürgerlich-Demokratische Partei',
            'Parteilos' => 'Parteilos',
        ];

        foreach ($parties as $code => $name) {
            $party = new Party();
            $party->setShort($code);
            $party->setName($name);

            $manager->persist($party);
        }

        $manager->flush();
    }
}
