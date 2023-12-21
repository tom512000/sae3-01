<?php


namespace App\Tests\Controller\Profil;

use App\Factory\UserFactory;
use App\Repository\UserRepository;
use App\Tests\Support\ControllerTester;

class ModificationProfilCest
{
    public function _before(ControllerTester $I)
    {
        UserFactory::createOne([
            'lastName' => 'test',
            'firstName' => 'test',
            'email' => 'test@gmail.com',
            'password' => 'test',
            'roles' => ['ROLE_USER'],
        ]);

        $I->amOnPage('/login');
        $I->see('Connexion');

        $I->submitForm('form', [
            'email' => 'test@gmail.com',
            'password' => 'test',
        ]);
    }

    // tests
    public function testAffichageProfilModificationPage(ControllerTester $I)
    {
        $I->amOnPage('/profil/modif');
        $I->see('MODIFIER LE PROFIL');
        $I->seeElement('.login_bloc form');

        $I->seeElement('input[name="user[firstName]"]');
        $I->seeElement('input[name="user[lastName]"]');
        $I->seeElement('input[name="user[phone]"]');
        $I->seeElement('input[name="user[email]"]');
        $I->seeElement('input[name="user[cv]"]');
        $I->seeElement('input[name="user[lettreMotiv]"]');

        $I->seeElement('label[for="firstName"]');
        $I->seeElement('label[for="lastName"]');
        $I->seeElement('label[for="phone"]');
        $I->seeElement('label[for="dateNais"]');
        $I->seeElement('label[for="email"]');
        $I->seeElement('label[for="cv"]');
        $I->seeElement('label[for="lettreMotiv"]');
    }
}
