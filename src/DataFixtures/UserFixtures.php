<?php

namespace App\DataFixtures;

use App\Factory\UserFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    /**
     * Charge les fixtures avec l'EntityManager fourni.
     *
     * @param ObjectManager $manager L'EntityManager utilisé pour persister les objets
     */
    public function load(ObjectManager $manager): void
    {
        UserFactory::createOne([
            'lastName' => 'Valentin',
            'firstName' => 'Cladel',
            'email' => 'valentin.cladel@gmail.com',
            'roles' => ['ROLE_ADMIN'],
        ]);
        UserFactory::createOne([
            'lastName' => 'Tom',
            'firstName' => 'Sikora',
            'email' => 'tom.sikora03@gmail.com',
            'roles' => ['ROLE_ADMIN'],
        ]);
        UserFactory::createMany(40);
    }
}
