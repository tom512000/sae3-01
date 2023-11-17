<?php

namespace App\DataFixtures;

use App\Factory\EntrepriseFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
;

class EntrepriseFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        EntrepriseFactory::createMany(20);
    }
}
