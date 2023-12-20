<?php


namespace App\Tests\Controller\Home;

use App\Factory\EntrepriseFactory;
use App\Factory\OffreFactory;
use App\Factory\TypeFactory;
use App\Tests\Support\ControllerTester;

class IndexCest
{
    public function _before(ControllerTester $I): void
    {
        EntrepriseFactory::createMany(10);
        TypeFactory::createOne([
            'libelle' => 'STAGE',
        ]);
        TypeFactory::createOne([
            'libelle' => 'ALTERNANCE',
        ]);
        OffreFactory::createMany(20);

    }

    // tests
    public function testHomePage(ControllerTester $I): void
    {
        $I->amOnPage('/home');
        $I->seeResponseCodeIs(200);
        $I->see('Accueil', 'title');
        $I->see('ACCUEIL', '.menu_bloc h1');
        $I->seeNumberOfElements('.menu_bloc h3 a', 4);
        $I->see('Offres récentes', '.titre_home h1');
        $I->seeNumberOfElements('.bloc_offre', 10);

    }
}
