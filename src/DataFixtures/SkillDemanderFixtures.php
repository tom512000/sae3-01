<?php

namespace App\DataFixtures;

use App\Factory\SkillDemanderFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class SkillDemanderFixtures extends Fixture implements DependentFixtureInterface
{
    /**
     * Charge les fixtures avec l'EntityManager fourni.
     *
     * @param ObjectManager $manager L'EntityManager utilisé pour persister les objets
     */
    public function load(ObjectManager $manager): void
    {
        SkillDemanderFactory::createMany(600);
    }

    /**
     * Obtient les classes de fixtures sur lesquelles la classe actuelle est dépendante.
     *
     * @return array La liste des classes de fixtures sur lesquelles cette fixture dépend
     */
    public function getDependencies(): array
    {
        return [
            OffreFixtures::class,
            SkillFixtures::class,
        ];
    }
}
