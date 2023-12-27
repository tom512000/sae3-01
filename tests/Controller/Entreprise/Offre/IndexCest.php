<?php

namespace App\Tests\Controller\Entreprise\Offre;

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
        EntrepriseFactory::createOne([
            'nomEnt' => 'AAAAAAAAA',
        ]);

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

        $ALTERNANCE = $typeRepository->find(1);
        $STAGE = $typeRepository->find(2);

        OffreFactory::createMany(10, [
            'Type' => $ALTERNANCE,
            'nomOffre' => 'TESTOFFRE',
            'level' => 'BAC +1',
        ]);

        OffreFactory::createOne([
            'Type' => $STAGE,
            'level' => 'BAC +2',
            'jourDeb' => new \DateTime('2230-05-05'),
        ]);

        OffreFactory::createOne([
            'nomOffre' => 'AAAAAAAA',
            'Type' => $STAGE,
            'level' => 'BAC +2',
            'jourDeb' => new \DateTime('1000-05-05'),
        ]);

        OffreFactory::createMany(10, [
            'Type' => $STAGE,
            'level' => 'BAC +5',
        ]);
    }

    // tests
    public function testEntrepriseOffrePage(ControllerTester $I): void
    {
        $I->amOnPage('/entreprise/offre?entrepriseId=1');
        $I->seeResponseCodeIs(200);
        $I->see('Offres', 'title');
        $I->see('LISTE DES OFFRES', '.titre_bloc h1');
        $I->seeNumberOfElements('.bloc_offre', 22);
    }

    public function testSearchByTypePageEntrepriseOffre(ControllerTester $I): void
    {
        $I->amOnPage('/entreprise/offre?entrepriseId=1&type=1');

        $I->seeResponseCodeIs(200);
        $I->seeNumberOfElements('.bloc_offre', 10);
    }

    public function testSearchByNiveauPageEntrepriseOffre(ControllerTester $I): void
    {
        $I->amOnPage('/entreprise/offre?entrepriseId=1&niveau=1');

        $I->seeResponseCodeIs(200);
        $I->seeNumberOfElements('.bloc_offre', 10);
    }

    public function testSearchByAfterDatePageEntrepriseOffre(ControllerTester $I): void
    {
        $I->amOnPage('/entreprise/offre?entrepriseId=1&date=2230-05-04&dateFiltre=2');

        $I->seeResponseCodeIs(200);
        $I->seeNumberOfElements('.bloc_offre', 1);
    }

    public function testSearchByBeforeDatePageEntrepriseOffre(ControllerTester $I): void
    {
        $I->amOnPage('/entreprise/offre?entrepriseId=1&date=1000-05-06&dateFiltre=1');

        $I->seeResponseCodeIs(200);
        $I->seeNumberOfElements('.bloc_offre', 1);
    }

    public function testSearchByTextPageEntrepriseOffre(ControllerTester $I): void
    {
        $I->amOnPage('/entreprise/offre?entrepriseId=1');

        $I->fillField('input[name="textRecherche"]', 'TESTOFFRE');
        $I->click('🔎');

        $I->seeResponseCodeIs(200);
        $I->seeNumberOfElements('.bloc_offre', 10);
    }

    public function testOnFirstClickOffrePageEntrepriseOffre(ControllerTester $I): void
    {
        $I->amOnPage('/entreprise/offre?entrepriseId=1');
        $I->seeResponseCodeIs(200);

        $I->click('.bloc_offres .bloc_offre:first-child .bloc_offre_txt a');

        $expectedRoute = '/offre/12';

        $currentRoute = $I->grabFromCurrentUrl();
        $I->assertEquals($expectedRoute, $currentRoute);
    }

    public function testOnFirstClickEnteprisePageEntrepriseOffre(ControllerTester $I): void
    {
        $I->amOnPage('/offre');
        $I->seeResponseCodeIs(200);

        $I->click('.bloc_offres .bloc_offre:first-child .bloc_offre_img a');

        $expectedRoute = '/entreprise/1';

        $currentRoute = $I->grabFromCurrentUrl();
        $I->assertEquals($expectedRoute, $currentRoute);
    }
}
