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
    private EntrepriseRepository $entrepriseRepository;
    private OffreRepository $offreRepository;

    /**
     * Constructeur du contrôleur.
     *
     * @param EntrepriseRepository $entrepriseRepository Le repository des entreprises
     * @param OffreRepository      $offreRepository      Le repository des offres
     */
    public function __construct(EntrepriseRepository $entrepriseRepository, OffreRepository $offreRepository)
    {
        $this->entrepriseRepository = $entrepriseRepository;
        $this->offreRepository = $offreRepository;
    }

    /**
     * Affiche la liste des entreprises.
     *
     * @param Request $request La requête HTTP
     *
     * @return Response La réponse HTTP
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
     * Affiche les détails d'une entreprise.
     *
     * @param Entreprise $Entreprises L'entreprise à afficher
     * @param Request    $request     La requête HTTP
     *
     * @return Response La réponse HTTP
     */
    #[Route('/entreprise/{entrepriseId}', name: 'app_entreprise_show', requirements: ['entrepriseId' => '\d+'])]
    public function show(
        #[MapEntity(expr: 'repository.find(entrepriseId)')]
        ?Entreprise $Entreprises,
        Request $request): Response
    {
        if (!$Entreprises) {
            return $this->redirectToRoute('app_entreprise_index');
        }
        $textRechercheEntreprise = $request->query->get('textRecherche', '');
        $nbOffres = $this->offreRepository->findNbOffresByEntreprisesReturnArray([$Entreprises])[$Entreprises->getId()];

        return $this->render('entreprise/show.html.twig', [
            'Entreprises' => $Entreprises,
            'textRechercheEntreprise' => $textRechercheEntreprise,
            'nbOffres' => $nbOffres,
        ]);
    }
}
