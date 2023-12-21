<?php


namespace App\Tests\Controller\Securite;

use App\Tests\Support\ControllerTester;
use App\Factory\UserFactory;
class ConnexionCest
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
    }

    // tests
    public function testValidLogin(ControllerTester $I)
    {
        $I->amOnPage('/login');
        $I->see('Connexion');

        $I->submitForm('form', [
            'email' => 'test@gmail.com',
            'password' => 'test',
        ]);

        $I->seeResponseCodeIsSuccessful();
    }

    public function testInvalidPassword(ControllerTester $I)
    {
        $I->amOnPage('/login');
        $I->see('Connexion');

        $I->submitForm('form', [
            'email' => 'test@gmail.com',
            'password' => 'wrong_password',
        ]);

        $I->seeResponseCodeIs(200);
        $I->see('ERREUR : DONNEES INVALIDES');
    }

    public function testInvalidEmail(ControllerTester $I)
    {
        $I->amOnPage('/login');
        $I->see('Connexion');

        $I->submitForm('form', [
            'email' => 'wrong_email@gmail.com',
            'password' => 'test',
        ]);

        $I->seeResponseCodeIs(200);
        $I->see('ERREUR : DONNEES INVALIDES');
    }
}
