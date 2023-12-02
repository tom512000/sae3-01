<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class InfoSiteController extends AbstractController
{
    #[Route('/a-propos', name: 'app_a-propos')]
    public function index(): Response
    {
        return $this->render('info_site/index.html.twig', [
            'controller_name' => 'InfoSiteController',
        ]);
    }

    #[Route('/mentions-legales', name: 'app_mentions')]
    public function mentions(): Response
    {
        return $this->render('info_site/mentions.html.twig', [
            'controller_name' => 'InfoSiteController',
        ]);
    }

    #[Route('/conditions-generales-d-utilisation', name: 'app_conditions')]
    public function conditions(): Response
    {
        return $this->render('info_site/conditions.html.twig', [
            'controller_name' => 'InfoSiteController',
        ]);
    }
}
