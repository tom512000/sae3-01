<?php

namespace App\Controller;

use App\Repository\OffreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OffreController extends AbstractController
{
    #[Route('/offre', name: 'app_offre_index')]
    public function index(OffreRepository $offreRepository, Request $request): Response
    {
        $textRechercher = $request->query->get('textRecherche', '');
        $Offres = $offreRepository->search($textRechercher);
        return $this->render('offre/index.html.twig', [
            'Offres'=>$Offres,
            'textRecherche' => $textRechercher,
        ]);
    }
}
