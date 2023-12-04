<?php

namespace App\Controller;

use App\Entity\Entreprise;
use App\Repository\EntrepriseRepository;
use App\Repository\OffreRepository;
use Doctrine\ORM\NonUniqueResultException;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_USER')]
class EntrepriseController extends AbstractController
{
    private EntrepriseRepository $entrepriseRepository;
    private OffreRepository $offreRepository;

    public function __construct(EntrepriseRepository $entrepriseRepository, OffreRepository $offreRepository)
    {
        $this->entrepriseRepository = $entrepriseRepository;
        $this->offreRepository = $offreRepository;
    }

    /**
     * @throws NonUniqueResultException
     */
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

    /**
     * @throws NonUniqueResultException
     */
    #[Route('/entreprise/{entrepriseId}', name: 'app_entreprise_show', requirements: ['entrepriseId' => '\d+'])]
    public function show(
        #[MapEntity(expr: 'repository.find(entrepriseId)')]
        Entreprise $Entreprises,
        Request $request): Response
    {
        $textRechercheEntreprise = $request->query->get('textRecherche', '');

        $nbOffres = $this->offreRepository->findNbOffresByEntreprisesReturnArray([$Entreprises])[$Entreprises->getId()];
        return $this->render('entreprise/index.html.twig', [
            'Entreprises'=>$Entreprises,
            'textRechercheEntreprise' => $textRechercheEntreprise,
            'nbOffres' => $nbOffres,
        ]);
    }
}
