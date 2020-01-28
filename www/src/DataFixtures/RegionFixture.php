<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Region;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class RegionFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $regions = [
            'ZH' => 'Zürich',
            'BE' => 'Bern',
            'LU' => 'Luzern',
            'UR' => 'Uri',
            'SZ' => 'Schwyz',
            'OW' => 'Obwalden',
            'NW' => 'Nidwalden',
            'GL' => 'Glarus',
            'ZG' => 'Zug',
            'FR' => 'Freiburg',
            'SO' => 'Solothurn',
            'BS' => 'Basel-Stadt',
            'BL' => 'Basel-Landschaft',
            'SH' => 'Schaffhausen',
            'AR' => 'Appenzell Ausserrhoden',
            'AI' => 'Appenzell Innerhoden',
            'SG' => 'St. Gallen',
            'GR' => 'Graubünden',
            'AG' => 'Aargau',
            'TG' => 'Thurgau',
            'TI' => 'Tessin',
            'VD' => 'Waadt',
            'VS' => 'Wallis',
            'NE' => 'Neuenburg',
            'GE' => 'Genf',
            'JU' => 'Jura',
        ];
        foreach ($regions as $code => $name) {
            $region = new Region();
            $region->setShort($code);
            $region->setName($name);

            $manager->persist($region);
        }

        $manager->flush();
    }
}
