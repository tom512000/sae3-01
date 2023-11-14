<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        return $this->redirect('/home', 303);
    }

    #[Route('/home', name: 'app_home_home')]
    public function home(): Response
    {
        return $this->render('home/index.html.twig');
    }
}
