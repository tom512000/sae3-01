<?php

namespace App\Controller;

use App\Repository\OffreRepository;
use App\Repository\TypeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_USER')]
class OffreController extends AbstractController
{
    #[Route('/offre', name: 'app_offre_index')]
    public function index(OffreRepository $offreRepository, Request $request, TypeRepository $typeRepository): Response
    {
        $textRechercher = $request->query->get('textRecherche', '');
        $typeRechercher = $request->query->get('type', 0);

        $Offres = $offreRepository->findByTypeAndText($typeRechercher, $textRechercher);

        $types = $typeRepository->findAll();

        return $this->render('offre/index.html.twig', [
            'Offres'=>$Offres,
            'textRecherche' => $textRechercher,
            'types' => $types,
        ]);
    }

    #[Route('/entreprise/offre/{entrepriseId}', name: 'app_offre_OffreEntreprise', requirements: ['entrepriseId' => '\d+'])]
    public function OffreEntreprise(int $entrepriseId, OffreRepository $offreRepository): Response
    {
        $Offres = $offreRepository->findByEntrepriseId($entrepriseId);

        return $this->render('offre/index.html.twig', [
            'Offres'=>$Offres,
        ]);
    }
}
