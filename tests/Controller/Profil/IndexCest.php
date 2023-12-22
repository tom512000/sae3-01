<?php

namespace App\Tests\Controller\Profil;

use App\Factory\UserFactory;
use App\Tests\Support\ControllerTester;

class IndexCest
{
    public function _before(ControllerTester $I): void
    {
        UserFactory::createOne([
            'lastName' => 'test',
            'firstName' => 'test',
            'email' => 'test@gmail.com',
            'password' => 'test',
            'roles' => [
                'ROLE_ADMIN',
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
    public function TestProfilPage(ControllerTester $I): void
    {
        $I->amOnPage('/profil');
        $I->see('Profil');

        $I->see('Nom :');
        $I->see('Prénom :');
        $I->see('Numéro de téléphone :');
        $I->see('Adresse mail :');
        $I->see('Date de Naissance :');
        $I->see('CV enregistré :');
        $I->see('Lettre de motivation enregistrée :');

        $I->see('Modifier mon profil', 'button');
        $I->see('Supprimer le compte', 'button');
    }
}
