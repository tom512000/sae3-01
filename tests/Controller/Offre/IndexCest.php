<?php


namespace App\Tests\Controller\Offre;

use App\Factory\EntrepriseFactory;
use App\Factory\OffreFactory;
use App\Factory\TypeFactory;
use App\Factory\UserFactory;
use App\Tests\Support\ControllerTester;
class IndexCest
{
    public function _before(ControllerTester $I)
    {
        EntrepriseFactory::createMany(10);

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

        $I->seeResponseCodeIsSuccessful();


        OffreFactory::createMany( 5,[
            'level' => '1',
            'Type' => TypeFactory::createOne([
                'libelle' => 'ALTERNANCE',
            ])
        ]);


        OffreFactory::createMany( 5,[
            'nomOffre'=> 'TEST',
            'level' => '2',
            'Type' => TypeFactory::createOne([
                'libelle' => 'STAGE',
            ])
        ]);

        OffreFactory::createMany( 5,[
            'level' => '3',
            'Type' => TypeFactory::createOne([
                'libelle' => 'STAGE',
            ]),
            'jourDeb' => new \DateTime('2023-12-05')
        ]);
    }


    // tests
    public function testOffrePage(ControllerTester $I): void
    {
        $I->amOnPage('/offre');
        $I->seeResponseCodeIs(200);
        $I->see('Offres', 'title');
        $I->see('LISTE DES OFFRES', '.titre_offre h1');
        $I->seeNumberOfElements('.bloc_offre', 14);
    }

    public function testSearchByType(ControllerTester $I): void
    {
        $I->amOnPage('/offre?type=1');

        $I->seeResponseCodeIs(200);
        $I->see('Offres', 'title');
        $I->see('LISTE DES OFFRES', '.titre_offre h1');
        $I->seeNumberOfElements('.bloc_offre', 5);
    }

    public function testSearchByNiveau(ControllerTester $I): void
    {
        $I->amOnPage('/offre?niveau=1');

        $I->seeResponseCodeIs(200);
        $I->see('Offres', 'title');
        $I->see('LISTE DES OFFRES', '.titre_offre h1');
        $I->seeNumberOfElements('.bloc_offre', 5);
    }

    public function testSearchByDate(ControllerTester $I): void
    {
        $I->amOnPage('/offre?date=2023-12-05');

        $I->seeResponseCodeIs(200);
        $I->see('Offres', 'title');
        $I->see('LISTE DES OFFRES', '.titre_offre h1');
        $I->seeNumberOfElements('.bloc_offre', 5);
    }

    public function testSearchByText(ControllerTester $I): void
    {
        $I->amOnPage('/offre');

        $I->fillField('input[name="textRecherche"]', 'test');
        $I->click('🔎');

        $I->seeResponseCodeIs(200);
        $I->see('Offres', 'title');
        $I->see('LISTE DES OFFRES', '.titre_offre h1');
        $I->seeNumberOfElements('.bloc_offre', 5);
    }

}
