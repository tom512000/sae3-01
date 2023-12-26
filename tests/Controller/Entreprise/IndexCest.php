<?php

namespace App\Tests\Controller\Entreprise;

use App\Factory\EntrepriseFactory;
use App\Factory\OffreFactory;
use App\Factory\TypeFactory;
use App\Factory\UserFactory;
use App\Repository\EntrepriseRepository;
use App\Tests\Support\ControllerTester;

class IndexCest
{
    public function _before(ControllerTester $I): void
    {
        EntrepriseFactory::createOne([
            'nomEnt' => 'AAAAAAAAA',
        ]);

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

        $EntrepriseRepository = $I->grabService(EntrepriseRepository::class);

        $Entreprise = $EntrepriseRepository->find(1);

        OffreFactory::createMany(10, [
            'entreprise' => $Entreprise,
        ]);
    }

    // tests
    public function testEntreprisePage(ControllerTester $I): void
    {
        $I->amOnPage('/entreprise');
        $I->seeResponseCodeIs(200);
        $I->see('Entreprises', 'title');
        $I->see('LISTE DES ENTREPRISES', '.titre_bloc h1');
        $I->seeNumberOfElements('.bloc_entreprise', 11);

        $I->see('annonces en ligne', '.bloc_entreprises .bloc_entreprise:first-child .infos_entreprise p');

        $I->seeElement('form[role="search"]');
        $I->seeElement('input.form-control');
        $I->seeElement('button.btn.btn-outline-success');
    }

    public function testOnFirstClickPageEntreprise(ControllerTester $I): void
    {
        $I->amOnPage('/entreprise');
        $I->seeResponseCodeIs(200);

        $I->click('.bloc_entreprises .bloc_entreprise:first-child .infos_entreprise a');

        $expectedRoute = '/entreprise/1';

        $currentRoute = $I->grabFromCurrentUrl();
        $I->assertEquals($expectedRoute, $currentRoute);
    }

    public function testSearchByTextPageEntreprise(ControllerTester $I): void
    {
        $I->amOnPage('/entreprise?textRecherche=AAAAAAAAA');

        $I->seeResponseCodeIs(200);
        $I->seeNumberOfElements('.bloc_entreprise', 1);
    }

    public function testSearchByTextNotExistPageEntreprise(ControllerTester $I): void
    {
        $I->amOnPage('/entreprise?textRecherche=BBBBBBBBBBBBB');

        $I->seeResponseCodeIs(200);

        $I->see('Aucune Entreprise trouvée', '.entreprise_menu h1');
    }
}
