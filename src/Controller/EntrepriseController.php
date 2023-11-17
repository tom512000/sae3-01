<?php

namespace App\Controller;

use App\Repository\EntrepriseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EntrepriseController extends AbstractController
{
    #[Route('/entreprise', name: 'app_entreprise_index')]
    public function index(EntrepriseRepository $EntrepriseRepository, Request $request): Response
    {
        $textRechercheEntreprise = $request->query->get('textRecherche', '');
        $Entreprises = $EntrepriseRepository->search($textRechercheEntreprise);

        return $this->render('entreprise/index.html.twig', [
            'Entreprises'=>$Entreprises,
            'textRechercheEntreprise' => $textRechercheEntreprise,
        ]);
    }
}
