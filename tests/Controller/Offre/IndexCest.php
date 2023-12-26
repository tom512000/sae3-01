<?php

namespace App\Tests\Controller\Offre;

use App\Factory\EntrepriseFactory;
use App\Factory\OffreFactory;
use App\Factory\TypeFactory;
use App\Factory\UserFactory;
use App\Repository\TypeRepository;
use App\Tests\Support\ControllerTester;

class IndexCest
{
    public function _before(ControllerTester $I): void
    {
        EntrepriseFactory::createMany(1);

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

        $typeRepository = $I->grabService(TypeRepository::class);

        $alternance = $typeRepository->find(1);
        $stage = $typeRepository->find(2);

        OffreFactory::createMany(10, [
            'Type' => $alternance,
            'nomOffre' => 'TEST',
            'level' => 'BAC +1',
        ]);

        OffreFactory::createOne([
            'Type' => $stage,
            'level' => 'BAC +2',
            'jourDeb' => new \DateTime('2230-05-05'),
        ]);

        OffreFactory::createOne([
            'nomOffre' => 'AAAAAAAA',
            'Type' => $stage,
            'level' => 'BAC +2',
            'jourDeb' => new \DateTime('1000-05-05'),
        ]);

        OffreFactory::createMany(10, [
            'Type' => $stage,
            'level' => 'BAC +5',
        ]);
    }

    // tests
    public function testOffrePage(ControllerTester $I): void
    {
        $I->amOnPage('/offre');
        $I->seeResponseCodeIs(200);
        $I->see('Offres', 'title');
        $I->see('LISTE DES OFFRES', '.titre_bloc h1');
        $I->seeNumberOfElements('.bloc_offre', 14);
    }

    public function testSearchByTypePageOffre(ControllerTester $I): void
    {
        $I->amOnPage('/offre?type=1');
        $I->seeResponseCodeIs(200);
        $I->seeNumberOfElements('.bloc_offre', 10);
    }

    public function testSearchByNiveauPageOffre(ControllerTester $I): void
    {
        $I->amOnPage('/offre?niveau=1');
        $I->seeResponseCodeIs(200);
        $I->seeNumberOfElements('.bloc_offre', 10);
    }

    public function testSearchByAfterDatePageOffre(ControllerTester $I): void
    {
        $I->amOnPage('/offre?date=2230-05-04&dateFiltre=2');
        $I->seeResponseCodeIs(200);
        $I->seeNumberOfElements('.bloc_offre', 1);
    }

    public function testSearchByBeforeDatePageOffre(ControllerTester $I): void
    {
        $I->amOnPage('/offre?date=1000-05-06&dateFiltre=1');
        $I->seeResponseCodeIs(200);
        $I->seeNumberOfElements('.bloc_offre', 1);
    }

    public function testSearchByTextPageOffre(ControllerTester $I): void
    {
        $I->amOnPage('/offre');

        $I->fillField('input[name="textRecherche"]', 'test');
        $I->click('🔎');

        $I->seeResponseCodeIs(200);
        $I->seeNumberOfElements('.bloc_offre', 10);
    }

    public function testOnFirstClickOffrePageOffre(ControllerTester $I): void
    {
        $I->amOnPage('/offre');
        $I->seeResponseCodeIs(200);

        $I->click('.bloc_offres .bloc_offre:first-child .bloc_offre_txt a');

        $expectedRoute = '/offre/12';

        $currentRoute = $I->grabFromCurrentUrl();
        $I->assertEquals($expectedRoute, $currentRoute);
    }

    public function testOnFirstClickEnteprisePageOffre(ControllerTester $I): void
    {
        $I->amOnPage('/offre');
        $I->seeResponseCodeIs(200);

        $I->click('.bloc_offres .bloc_offre:first-child .bloc_offre_img a');

        $expectedRoute = '/entreprise/1';

        $currentRoute = $I->grabFromCurrentUrl();
        $I->assertEquals($expectedRoute, $currentRoute);
    }
}
