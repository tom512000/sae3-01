<?php

namespace App\Tests\Controller\Securite;

use App\Tests\Support\ControllerTester;

class newUserCest
{
    public function _before(ControllerTester $I): void
    {
    }

    // tests
    public function tryToTest(ControllerTester $I): void
    {
        $I->amOnPage('/newUser');
        $I->see('CRÉER MON COMPTE');

        $I->submitForm('form', [
            'lastName' => 'test',
            'firstName' => 'test',
            'email' => 'test@gmail.com',
            'phone' => '0689252449',
            'dateNais' => '2004-05-05',
            'password' => 'test',
        ]);

        $I->amOnPage('/login');

        $I->submitForm('form', [
            'email' => 'test@gmail.com',
            'password' => 'test',
        ]);

        $I->seeResponseCodeIsSuccessful();
    }
}
