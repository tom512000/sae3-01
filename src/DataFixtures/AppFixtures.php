<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    /**
     * Charge les données dans la base de données.
     *
     * @param objectManager $manager L'instance de l'ObjectManager pour interagir avec la base de données
     */
    public function load(ObjectManager $manager): void
    {
        $manager->flush();
    }
}
