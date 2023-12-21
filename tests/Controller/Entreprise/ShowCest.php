<?php


namespace App\Tests\Controller\Entreprise;

use App\Factory\EntrepriseFactory;
use App\Factory\OffreFactory;
use App\Factory\TypeFactory;
use App\Factory\UserFactory;
use App\Repository\EntrepriseRepository;
use App\Repository\OffreRepository;
use App\Tests\Support\ControllerTester;

class ShowCest
{
    public function _before(ControllerTester $I)
    {
        EntrepriseFactory::createOne([
            'nomEnt' => 'TESTEntreprise',
            'adresse' => '3, boulevard de Morvan 47 739 Marques',
            'mail' => 'begue@roussel.fr',
            'siteWeb' => 'https://begue.legros.fr/'
        ]);

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

        TypeFactory::createOne([
            'libelle' => 'ALTERNANCE',
        ]);

        TypeFactory::createOne([
            'libelle' => 'STAGE',
        ]);

        $EntrepriseRepository = $I->grabService(EntrepriseRepository::class);

        $Entreprise = $EntrepriseRepository->find(1);

        OffreFactory::createMany(10,[
            'entreprise' => $Entreprise
        ]);
    }

    // tests
    public function testEntrepriseShowPage(ControllerTester $I): void
    {
        $I->amOnPage('/entreprise/1');
        $I->seeResponseCodeIs(200);
        $I->see('Entreprise', 'title');

        $I->see('TESTEntreprise', '.details_entreprise .details_entreprise_1 h1');
        $I->see('10 annonces en ligne', '.details_entreprise .details_entreprise_1 p');


        $I->see('INFORMATIONS','.details_entreprise_2 h2');
        $I->see('3, boulevard de Morvan 47 739 Marques', '.details_entreprise_2 p');
        $I->see('begue@roussel.fr', '.details_entreprise_2 p');



    }
}
