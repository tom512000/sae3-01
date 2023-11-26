<?php

namespace App\DataFixtures;

use App\Factory\SkillDemanderFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;


class SkillDemanderFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        SkillDemanderFactory::createMany(20);
    }

    public function getDependencies(): array
    {
        return [
            OffreFixtures::class,
            SkillFixtures::class
        ];
    }
}
