<?php

namespace App\DataFixtures;

use App\Factory\TypeFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TypeFixtures extends Fixture
{
    /**
     * Charge les fixtures avec l'EntityManager fourni.
     *
     * @param ObjectManager $manager L'EntityManager utilisé pour persister les objets
     */
    public function load(ObjectManager $manager): void
    {
        TypeFactory::createOne([
            'libelle' => 'STAGE',
        ]);
        TypeFactory::createOne([
            'libelle' => 'ALTERNANCE',
        ]);
    }
}
