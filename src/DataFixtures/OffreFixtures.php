<?php

namespace App\DataFixtures;

use App\Factory\OffreFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class OffreFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        OffreFactory::createMany(80);
    }
}
