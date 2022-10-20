<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\PoliticianType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class PoliticianTypeFixture extends Fixture
{
    public const POLITICIAN_TYPE_SR = 'sr';

    public function load(ObjectManager $manager): void
    {
        $politicianType = new PoliticianType();
        $politicianType->setName('Ständerat');

        $manager->persist($politicianType);
        $manager->flush();

        $this->addReference(self::POLITICIAN_TYPE_SR, $politicianType);
    }
}
