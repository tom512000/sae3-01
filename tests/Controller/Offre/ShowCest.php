<?php

namespace App\Tests\Controller\Offre;

use App\Factory\EntrepriseFactory;
use App\Factory\OffreFactory;
use App\Factory\SkillDemanderFactory;
use App\Factory\SkillFactory;
use App\Factory\TypeFactory;
use App\Factory\UserFactory;
use App\Repository\TypeRepository;
use App\Tests\Support\ControllerTester;

class ShowCest
{
    public function _before(ControllerTester $I): void
    {
        EntrepriseFactory::createOne([
            'nomEnt' => 'test',
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

        $typeRepository = $I->grabService(TypeRepository::class);

        $alternance = $typeRepository->find(1);

        OffreFactory::createOne([
            'Type' => $alternance,
            'nomOffre' => 'TESTOffre',
            'level' => 'BAC +1',
            'duree' => 20,
            'lieux' => '64, avenue de Valette 78404 Bousquet',
            'jourDeb' => new \DateTime('2023-05-05'),
            'nbPlace' => 8,
        ]);

        $competences = [
            'Communication',
            'Travail d\'équipe',
            'Résolution de problèmes',
            'Leadership',
        ];

        for ($i = 0; $i < count($competences); ++$i) {
            SkillFactory::createOne([
                'libelle' => $competences[$i],
            ]);

            SkillDemanderFactory::createOne();
        }
    }

    // tests
    public function testOffreShowPage(ControllerTester $I): void
    {
        $I->amOnPage('/offre/1');
        $I->seeResponseCodeIs(200);
        $I->see('Offres', 'title');

        $I->see('TESTOffre', '.bloc_offre_infos_1 h2');

        $I->see('Début du  ALTERNANCE  le  05 May 2023  à l\'adresse :  64, avenue de Valette 78404 Bousquet.', '.bloc_offre_infos_2 p:first-child');
        $I->see('Description', '.bloc_offre_infos_2 h4');

        $I->see('Niveau', '.bloc_offre_infos_3 div:first-child h4');
        $I->see('BAC +1', '.bloc_offre_infos_3 div:first-child p');

        $I->see('Durée', '.bloc_offre_infos_3 div:nth-child(2) h4');
        $I->see('20 jours', '.bloc_offre_infos_3 div:nth-child(2) p');

        $I->see('Places restantes', '.bloc_offre_infos_3 div:nth-child(3) h4');
        $I->see('8 places', '.bloc_offre_infos_3 div:nth-child(3) p');

        $I->seeElement('.inscrip-button button.btn-success');
        $I->see('S\'inscrire', '.inscrip-button button.btn-success');

        $I->see('Compétences', '.bloc_offre_infos_4');
        $I->seeNumberOfElements('.bloc_offre_infos_4 p', 4);
    }

    public function testOffreInconuePageOffreShow(ControllerTester $I): void
    {
        $I->amOnPage('/offre/10');

        $expectedRoute = '/offre';
        $currentRoute = $I->grabFromCurrentUrl();

        $I->assertEquals($expectedRoute, $currentRoute);
    }

    public function testOnFirstClickEnteprisePageOffreShow(ControllerTester $I): void
    {
        $I->amOnPage('/offre/1');
        $I->seeResponseCodeIs(200);

        $I->click('.bloc_offre_infos_1 a');

        $expectedRoute = '/entreprise/1';
        $currentRoute = $I->grabFromCurrentUrl();

        $I->assertEquals($expectedRoute, $currentRoute);
    }
}
