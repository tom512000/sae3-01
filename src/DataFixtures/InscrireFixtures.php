<?php

namespace App\DataFixtures;

use App\Factory\EntrepriseFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
;

class InscrireFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        EntrepriseFactory::createMany(10);
    }
    public function getDependencies()
    {
        return [
            UserFixtures::class,
            OffreFixtures::class
        ];
    }

}
