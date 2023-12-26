<?php

namespace App\Tests\Controller\Inscrire;

use App\Factory\EntrepriseFactory;
use App\Factory\InscrireFactory;
use App\Factory\OffreFactory;
use App\Factory\TypeFactory;
use App\Factory\UserFactory;
use App\Tests\Support\ControllerTester;

class IndexCest
{
    public function _before(ControllerTester $I): void
    {
        EntrepriseFactory::createMany(10);

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

        TypeFactory::createOne([
            'libelle' => 'ALTERNANCE',
        ]);

        TypeFactory::createOne([
            'libelle' => 'STAGE',
        ]);

        OffreFactory::createMany(10);
    }

    // tests
    public function testAucunInscriptionsPage(ControllerTester $I): void
    {
        $I->amOnPage('/inscription');
        $I->see('MES INSCRIPTIONS', '.titre_bloc h1');
        $I->seeElement('.bloc_legende');
        $I->seeElement('.bloc_offres_vide h1');
    }

    public function testInscriptionsPage(ControllerTester $I): void
    {
        InscrireFactory::createMany(2);

        $I->amOnPage('/inscription');
        $I->see('MES INSCRIPTIONS', '.titre_bloc h1');
        $I->seeElement('.bloc_legende');
        $I->seeElement('.bloc_offres');
        $I->seeElement('.bloc_offre');
        $I->seeElement('.bloc_offre_img');
        $I->seeElement('.bloc_offre_txt');
        $I->seeElement('.infos1');
        $I->seeElement('.infos2');
        $I->seeElement('.description');
        $I->seeElement('.infos3');
        $I->seeElement('.inscrip-button button');
    }

    public function TestInsriptionOffre(ControllerTester $I): void
    {
        $I->amOnPage('/offre');
        $I->seeResponseCodeIs(200);

        $I->click('S\'inscrire');

        $expectedRoute = '/inscription';
        $currentRoute = $I->grabFromCurrentUrl();

        $I->assertEquals($expectedRoute, $currentRoute);
        $I->seeNumberOfElements('.bloc_offre', 1);
    }

    public function TestDesincriptionOffre(ControllerTester $I): void
    {
        $I->amOnPage('/offre');
        $I->seeResponseCodeIs(200);

        $I->click('S\'inscrire');

        $expectedRoute = '/inscription';
        $currentRoute = $I->grabFromCurrentUrl();

        $I->assertEquals($expectedRoute, $currentRoute);
        $I->seeNumberOfElements('.bloc_offre', 1);

        $I->click('Se Désincrire');

        $currentRoute = $I->grabFromCurrentUrl();

        $I->assertEquals($expectedRoute, $currentRoute);
        $I->seeNumberOfElements('.bloc_offre', 0);
    }
}
