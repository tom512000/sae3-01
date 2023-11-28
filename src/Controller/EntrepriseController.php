<?php

namespace App\Controller;

use App\Repository\EntrepriseRepository;
use App\Repository\OffreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_USER')]
class EntrepriseController extends AbstractController
{
    #[Route('/entreprise', name: 'app_entreprise_index')]
    public function index(EntrepriseRepository $EntrepriseRepository, Request $request, OffreRepository $offreRepository): Response
    {
        $textRechercheEntreprise = $request->query->get('textRecherche', '');
        $Entreprises = $EntrepriseRepository->search($textRechercheEntreprise);

        $nbOffres = [];

        foreach ($Entreprises as $Entreprise) {
            $nbOffres[$Entreprise->getId()] = $offreRepository->findNbOffreByEntreprise($Entreprise->getId());
        }

        return $this->render('entreprise/index.html.twig', [
            'Entreprises'=>$Entreprises,
            'textRechercheEntreprise' => $textRechercheEntreprise,
            'nbOffres' => $nbOffres
        ]);
    }

    #[Route('/entreprise/{entrepriseId}', name: 'app_entreprise_show', requirements: ['entrepriseId' => '\d+'])]
    public function show(int $entrepriseId,EntrepriseRepository $EntrepriseRepository, Request $request): Response
    {
        $textRechercheEntreprise = $request->query->get('textRecherche', '');
        $Entreprises = $EntrepriseRepository->find($entrepriseId);

        if (!$Entreprises) {
            throw $this->createNotFoundException("Entreprise n'a pas été trouver ");
        }


        return $this->render('entreprise/index.html.twig', [
            'Entreprises'=>$Entreprises,
            'textRechercheEntreprise' => $textRechercheEntreprise,
        ]);
    }
}
