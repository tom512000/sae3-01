<?php

namespace App\Controller;

use App\Entity\Entreprise;
use App\Repository\EntrepriseRepository;
use App\Repository\OffreRepository;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_USER')]
class EntrepriseController extends AbstractController
{
    private $entrepriseRepository;
    private $offreRepository;

    public function __construct(EntrepriseRepository $entrepriseRepository, OffreRepository $offreRepository)
    {
        $this->entrepriseRepository = $entrepriseRepository;
        $this->offreRepository = $offreRepository;
    }

    #[Route('/entreprise', name: 'app_entreprise_index')]
    public function index(Request $request): Response
    {
        $textRechercheEntreprise = $request->query->get('textRecherche', '');

        $entreprises = $this->entrepriseRepository->search($textRechercheEntreprise);

        $nbOffres = $this->offreRepository->findNbOffresByEntreprisesReturnArray($entreprises);

        return $this->render('entreprise/index.html.twig', [
            'Entreprises' => $entreprises,
            'textRechercheEntreprise' => $textRechercheEntreprise,
            'nbOffres' => $nbOffres,
        ]);
    }

    #[Route('/entreprise/{entrepriseId}', name: 'app_entreprise_show', requirements: ['entrepriseId' => '\d+'])]
    public function show(
        #[MapEntity(expr: 'repository.find(entrepriseId)')]
        Entreprise $Entreprises,
        Request $request): Response
    {
        $textRechercheEntreprise = $request->query->get('textRecherche', '');

        if (!$Entreprises) {
            throw $this->createNotFoundException("Entreprise n'a pas été trouver ");
        }

        $nbOffres = $this->offreRepository->findNbOffresByEntreprisesReturnArray([$Entreprises])[$Entreprises->getId()];
        return $this->render('entreprise/index.html.twig', [
            'Entreprises'=>$Entreprises,
            'textRechercheEntreprise' => $textRechercheEntreprise,
            'nbOffres' => $nbOffres,
        ]);
    }
}
