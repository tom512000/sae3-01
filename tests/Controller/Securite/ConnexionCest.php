<?php

namespace App\Tests\Controller\Securite;

use App\Factory\UserFactory;
use App\Tests\Support\ControllerTester;

class ConnexionCest
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
    }

    // tests
    public function testValidLogin(ControllerTester $I): void
    {
        $I->amOnPage('/login');
        $I->see('Connexion');

        $I->submitForm('form', [
            'email' => 'test@gmail.com',
            'password' => 'test',
        ]);

        $I->seeResponseCodeIsSuccessful();
    }

    public function testInvalidPassword(ControllerTester $I): void
    {
        $I->amOnPage('/login');
        $I->see('Connexion');

        $I->submitForm('form', [
            'email' => 'test@gmail.com',
            'password' => 'wrong_password',
        ]);

        $I->seeResponseCodeIs(200);
        $I->see('Une ou plusieurs données sont invalides.');
    }

    public function testInvalidEmail(ControllerTester $I): void
    {
        $I->amOnPage('/login');
        $I->see('Connexion');

        $I->submitForm('form', [
            'email' => 'wrong_email@gmail.com',
            'password' => 'test',
        ]);

        $I->seeResponseCodeIs(200);
        $I->see('Une ou plusieurs données sont invalides.');
    }

    public function testClickInscriptionUser(ControllerTester $I): void
    {
        $I->amOnPage('/login');
        $I->seeResponseCodeIs(200);

        $I->click('.login_form .register_account a');

        $expectedRoute = '/newUser';

        $currentRoute = $I->grabFromCurrentUrl();

        $I->assertEquals($expectedRoute, $currentRoute);
    }
}
