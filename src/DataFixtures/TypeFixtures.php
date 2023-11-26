<?php

namespace App\DataFixtures;

use App\Factory\TypeFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
;

class TypeFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        TypeFactory::createOne(['libelle'=>'STAGE']);
        TypeFactory::createOne(['libelle'=>'ALTERNANCE']);
    }
}
