<?php

namespace App\Tests\Controller\Profil;

use App\Factory\UserFactory;
use App\Tests\Support\ControllerTester;

class ModificationProfilCest
{
    public function _before(ControllerTester $I): void
    {
        UserFactory::createOne([
            'lastName' => 'test',
            'firstName' => 'test',
            'email' => 'test@gmail.com',
            'password' => 'test',
            'roles' => [
                'ROLE_USER',
            ],
        ]);

        $I->amOnPage('/login');
        $I->see('Connexion');

        $I->submitForm('form', [
            'email' => 'test@gmail.com',
            'password' => 'test',
        ]);
    }

    // tests
    public function testAffichageProfilModificationPage(ControllerTester $I): void
    {
        $I->amOnPage('/profil/modif');
        $I->see('MODIFIER MON PROFIL', 'h1');
        $I->seeElement('.login_bloc form');
    }
}
