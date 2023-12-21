<?php


namespace App\Tests\Controller\Securite;

use App\Factory\UserFactory;
use App\Tests\Support\ControllerTester;

class newUserCest
{
    public function _before(ControllerTester $I)
    {
    }

    // tests
    public function tryToTest(ControllerTester $I)
    {
        $I->amOnPage('/newUser');
        $I->see('CRÉATION DU COMPTE');

        $I->submitForm('form', [
            'lastName' => 'test',
            'firstName' => 'test',
            'email' => 'test@gmail.com',
            'phone' => '0689252449',
            'dateNais'=> '2004-05-05',
            'password' => 'test'
        ]);

        $I->amOnPage('/login');

        $I->submitForm('form', [
            'email' => 'test@gmail.com',
            'password' => 'test',
        ]);

        $I->seeResponseCodeIsSuccessful();
    }
}
