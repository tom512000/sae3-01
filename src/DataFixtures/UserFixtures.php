<?php

namespace App\DataFixtures;

use App\Factory\UserFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        UserFactory::createOne(['lastName'=>'Valentin','firstName'=>'Cladel','email'=>'valentin.cladel@gmail.com','roles'=>['ROLE_ADMIN']]);
        UserFactory::createMany(40);
    }
}
