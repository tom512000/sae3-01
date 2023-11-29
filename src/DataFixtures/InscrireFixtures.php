<?php

namespace App\DataFixtures;

use App\Factory\InscrireFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
;

class InscrireFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        InscrireFactory::createMany(80);
    }
    public function getDependencies()
    {
        return [
            UserFixtures::class,
            OffreFixtures::class
        ];
    }

}
