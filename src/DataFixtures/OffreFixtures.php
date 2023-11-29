<?php

namespace App\DataFixtures;

use App\Factory\OffreFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;


class OffreFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        OffreFactory::createMany(220);
    }

    public function getDependencies()
    {
        return [
            EntrepriseFixtures::class
        ];
    }
}
