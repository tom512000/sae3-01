<?php


namespace App\Tests\Controller\Profil;

use App\Factory\UserFactory;
use App\Tests\Support\ControllerTester;

class IndexCest
{
    public function _before(ControllerTester $I)
    {
        UserFactory::createOne([
            'lastName' => 'test',
            'firstName' => 'test',
            'email' => 'test@gmail.com',
            'password' => 'test',
            'roles' => ['ROLE_ADMIN'],
        ]);

        $I->amOnPage('/login');
        $I->see('Connexion');

        $I->submitForm('form', [
            'email' => 'test@gmail.com',
            'password' => 'test',
        ]);
    }

    // tests
    public function TestProfilPage(ControllerTester $I)
    {
        $I->amOnPage('/profil');

        // Vérifiez que le titre "Profil" est présent sur la page
        $I->see('Profil');

        // Vérifiez la présence d'informations spécifiques sur le profil (ajoutez d'autres vérifications au besoin)
        $I->see('Nom :');
        $I->see('Prénom :');
        $I->see('Numéro de téléphone :');
        $I->see('Adresse mail :');
        $I->see('Date de Naissance :');
        $I->see('CV enregistré :');
        $I->see('Lettre de motivation enregistrée :');

        // Vérifiez la présence des liens pour modifier le profil et supprimer le compte
        $I->see('Modifier mon profil','button');
        $I->see('Supprimer le compte','button');
    }
}
