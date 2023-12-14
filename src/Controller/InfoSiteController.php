<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class InfoSiteController extends AbstractController
{
    /**
     * Affiche la page "À propos" du site.
     *
     * @return Response La réponse HTTP de la page "À propos"
     */
    #[Route('/a-propos', name: 'app_a-propos')]
    public function index(): Response
    {
        return $this->render('info_site/index.html.twig', [
            'controller_name' => 'InfoSiteController',
        ]);
    }

    /**
     * Affiche la page des mentions légales du site.
     *
     * @return Response La réponse HTTP de la page des mentions légales
     */
    #[Route('/mentions-legales', name: 'app_mentions')]
    public function mentions(): Response
    {
        return $this->render('info_site/mentions.html.twig', [
            'controller_name' => 'InfoSiteController',
        ]);
    }

    /**
     * Affiche la page des conditions générales d'utilisation du site.
     *
     * @return Response La réponse HTTP de la page des conditions générales d'utilisation
     */
    #[Route('/conditions-generales-d-utilisation', name: 'app_conditions')]
    public function conditions(): Response
    {
        return $this->render('info_site/conditions.html.twig', [
            'controller_name' => 'InfoSiteController',
        ]);
    }
}
