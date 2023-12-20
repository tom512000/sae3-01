<?php


namespace App\Tests\Controller\Securite;

use App\Tests\Support\ControllerTester;
use App\Factory\UserFactory;
class ConnexionCest
{
    public function _before(ControllerTester $I)
    {
        UserFactory::createOne([
            'lastName' => 'test',
            'firstName' => 'test',
            'email' => 'test@gmail.com',
            'roles' => ['ROLE_ADMIN'],
        ]);
    }

    // tests
    public function tryToTest(ControllerTester $I)
    {
    }


    public function testValidLogin(ControllerTester $I)
    {
        $crawler = $client->request('GET', '/login');
        $form = $crawler->selectButton('SE CONNECTER')->form([
            '_username' => 'votre_bon_email',
            '_password' => 'votre_bon_mot_de_passe',
        ]);

        $client->submit($form);

        // Vérifiez que la connexion a réussi (vous pouvez ajuster cela en fonction de votre logique d'authentification)
        $this->assertResponseRedirects('/'); // Redirige vers la page d'accueil après la connexion
        $client->followRedirect();
        $this->assertResponseIsSuccessful(); // Vérifie que la page suivante est accessible après la connexion
    }

    public function testInvalidPassword(ControllerTester $I)
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/login');
        $form = $crawler->selectButton('SE CONNECTER')->form([
            '_username' => 'votre_bon_email',
            '_password' => 'mauvais_mot_de_passe',
        ]);

        $client->submit($form);

        // Vérifiez que la connexion a échoué en raison d'un mot de passe incorrect
        $this->assertResponseStatusCodeSame(200); // Page de connexion à nouveau
        $this->assertSelectorTextContains('.login_form h1', 'ERREUR : DONNEES INVALIDES');
    }

    public function testInvalidEmail(ControllerTester $I)
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/login');
        $form = $crawler->selectButton('SE CONNECTER')->form([
            '_username' => 'mauvais_email@example.com',
            '_password' => 'votre_bon_mot_de_passe',
        ]);

        $client->submit($form);

        // Vérifiez que la connexion a échoué en raison d'un email incorrect
        $this->assertResponseStatusCodeSame(200); // Page de connexion à nouveau
        $this->assertSelectorTextContains('.login_form h1', 'ERREUR : DONNEES INVALIDES');
    }
}
