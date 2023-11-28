<?php

namespace App\Controller;

use App\Repository\InscrireRepository;
use App\Repository\OffreRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class InscireController extends AbstractController
{
    #[Route('/inscription', name: 'app_inscire')]
    public function index(InscrireRepository $inscrireRepository, Security $security): Response
    {
        $user = $security->getUser();

        if ($user) {
            $userId = $user->getId();

            $inscriptions = $inscrireRepository->findByUserId($userId);

            return $this->render('inscrire/index.html.twig', [
                'inscriptions' => $inscriptions,
            ]);
        } else {
            return $this->redirectToRoute('app_login');
        }
    }

    #[Route('/inscription/{idOffre}', name: 'app_inscire_inscription', requirements: ['idOffre' => '\d+'])]
    public function inscription(int $idOffre,InscrireRepository $inscrireRepository,
                                OffreRepository $offreRepository, Security $security){
        $offre = $offreRepository->find($idOffre);
        if ($offre != null){
            $inscrireRepository->inscription($offre,$security);
        }
        return $this->redirectToRoute('app_inscire');
    }

    #[Route('/desinscription/{idOffre}', name: 'app_inscire_desinscription', requirements: ['idOffre' => '\d+'])]
    public function desinscription(int $idOffre,InscrireRepository $inscrireRepository,
                                OffreRepository $offreRepository, Security $security){
        $offre = $offreRepository->find($idOffre);
        if ($offre != null){
            $inscrireRepository->desinscription($offre,$security);
        }
        return $this->redirectToRoute('app_inscire');
    }
}
