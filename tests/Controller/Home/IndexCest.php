<?php


namespace App\Tests\Controller\Home;

use App\Factory\EntrepriseFactory;
use App\Factory\OffreFactory;
use App\Factory\TypeFactory;
use App\Factory\UserFactory;
use App\Repository\TypeRepository;
use App\Tests\Support\ControllerTester;

class IndexCest
{
    public function _before(ControllerTester $I)
    {
        EntrepriseFactory::createMany(1);

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
        $typeRepository = $I->grabService(TypeRepository::class);

        $ALTERNANCE = $typeRepository->find(1);
        $STAGE = $typeRepository->find(2);

        OffreFactory::createMany(10,[
            'Type'=>$ALTERNANCE,
            'nomOffre' => "TEST",
            'level' => 'BAC +1'
        ]);

        OffreFactory::createOne([
            'nomOffre' => 'AAAAAAAA',
            'Type'=>$STAGE,
            'level'=> 'BAC +2',
            'jourDeb' => new \DateTime('1000-05-05'),
        ]);
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

    public function testOnFirstClickOffrePageHome(ControllerTester $I): void
    {
        $I->amOnPage('/home');
        $I->seeResponseCodeIs(200);

        $I->click('.bloc_offres .bloc_offre:first-child .bloc_offre_txt a');

        $expectedRoute = '/offre/11';

        $currentRoute = $I->grabFromCurrentUrl();
        $I->assertEquals($expectedRoute, $currentRoute);
    }

    public function testOnFirstClickEnteprisePageHome(ControllerTester $I): void
    {
        $I->amOnPage('/home');
        $I->seeResponseCodeIs(200);

        $I->click('.bloc_offres .bloc_offre:first-child .bloc_offre_img a');

        $expectedRoute = '/entreprise/1';

        $currentRoute = $I->grabFromCurrentUrl();
        $I->assertEquals($expectedRoute, $currentRoute);
    }
}
