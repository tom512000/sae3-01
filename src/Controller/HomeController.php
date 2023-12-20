<?php

namespace App\Controller;

use App\Repository\InscrireRepository;
use App\Repository\OffreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class HomeController extends AbstractController
{
    /**
     * Redirige vers la page d'accueil.
     *
     * @return Response La réponse HTTP de la redirection
     */
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        return $this->redirect('/home', 303);
    }

    /**
     * Affiche la page d'accueil.
     *
     * @param OffreRepository    $offreRepository    Le repository des offres
     * @param InscrireRepository $inscrireRepository Le repository des inscriptions
     * @param Security           $security           Le service de sécurité Symfony
     *
     * @return Response La réponse HTTP de la page d'accueil
     */
    #[Route('/home', name: 'app_home_home')]
    public function home(OffreRepository $offreRepository, InscrireRepository $inscrireRepository, Security $security): Response
    {
        $Offres = $offreRepository->findByRecent();
        $inscription = $inscrireRepository->getInscriptions($Offres, $security);

        return $this->render('home/index.html.twig', [
            'Offres' => $Offres,
            'inscription' => $inscription,
        ]);
    }
}
