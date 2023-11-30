<?php

namespace App\Controller;

use App\Entity\Offre;
use App\Repository\InscrireRepository;
use App\Repository\OffreRepository;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {

        return $this->redirect('/home', 303);
    }

    #[Route('/home', name: 'app_home_home')]
    public function home(OffreRepository $offreRepository, InscrireRepository $inscrireRepository, Security $security): Response
    {
        $Offres = $offreRepository->findByRecent();

        $inscription = $inscrireRepository->getInscriptions($Offres, $security);


        return $this->render('home/index.html.twig',[
            'Offres'=>$Offres,
            'inscription' => $inscription
        ]);
    }
}
