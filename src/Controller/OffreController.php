<?php

namespace App\Controller;

use App\Entity\Offre;
use App\Repository\InscrireRepository;
use App\Repository\OffreRepository;
use App\Repository\SkillDemanderRepository;
use App\Repository\TypeRepository;
use Exception;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Security\Core\Security;

#[IsGranted('ROLE_USER')]
class OffreController extends AbstractController
{
    private OffreRepository $offreRepository;
    private TypeRepository $typeRepository;
    private InscrireRepository $inscrireRepository;
    private Security $security;
    private SkillDemanderRepository $skillDemanderRepository;

    public function __construct(
        OffreRepository $offreRepository,
        TypeRepository $typeRepository,
        InscrireRepository $inscrireRepository,
        Security $security,
        SkillDemanderRepository $skillDemanderRepository
    ) {
        $this->offreRepository = $offreRepository;
        $this->typeRepository = $typeRepository;
        $this->inscrireRepository = $inscrireRepository;
        $this->security = $security;
        $this->skillDemanderRepository = $skillDemanderRepository;
    }

    /**
     * @throws Exception
     */
    #[Route('/offre', name: 'app_offre_index')]
    public function index(Request $request, PaginatorInterface $paginator): Response
    {
        $textRechercher = $request->query->get('textRecherche', '');
        $typeRechercher = $request->query->get('type', 0);
        $niveauRechercher = (int) $request->query->get('niveau', -1);
        $dateRechercher = $request->query->get('date', '');
        $dateFiltreRechercher = $request->query->get('dateFiltre', 0);

        $query = $this->offreRepository->findByFilter($typeRechercher, $textRechercher, $niveauRechercher, $dateRechercher, $dateFiltreRechercher);

        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            14  # Nombre d'offre par page
        );

        $types = $this->typeRepository->findAll();
        $inscription = $this->inscrireRepository->getInscriptions($pagination->getItems(), $this->security);
        $nbInscriptionAccepter = $this->offreRepository->getNbInscriptionsAccepter($pagination->getItems());


        return $this->render('offre/index.html.twig', [
            'Offres' => $pagination,
            'textRecherche' => $textRechercher,
            'types' => $types,
            'inscription' => $inscription,
            'nbInscriptionAccepter' => $nbInscriptionAccepter
        ]);
    }


    /**
     * @throws Exception
     */
    #[Route('/entreprise/offre', name: 'app_offre_OffreEntreprise', requirements: ['entrepriseId' => '\d+'])]
    public function OffreEntreprise(Request $request): Response
    {
        $textRechercher = $request->query->get('textRecherche', '');
        $typeRechercher = $request->query->get('type', 0);
        $entrepriseId = $request->query->get('entrepriseId');
        $niveauRechercher = (int) $request->query->get('niveau', -1);
        $dateRechercher = $request->query->get('date', '');
        $dateFiltreRechercher = $request->query->get('dateFiltre', 0);

        $Offres = $this->offreRepository->findByFilterByEntrepriseId($entrepriseId, $typeRechercher, $textRechercher, $niveauRechercher, $dateRechercher, $dateFiltreRechercher);
        $types = $this->typeRepository->findAll();
        $inscription = $this->inscrireRepository->getInscriptions($Offres, $this->security);

        $nbInscriptionAccepter = $this->offreRepository->getNbInscriptionsAccepter($Offres);

        return $this->render('entreprise/offre/index.html.twig', [
            'types' => $types,
            'textRecherche' => $textRechercher,
            'Offres' => $Offres,
            'entrepriseId' => $entrepriseId,
            'inscription' => $inscription,
            'nbInscriptionAccepter' => $nbInscriptionAccepter
        ]);
    }

    #[Route('/offre/{offreId}', name: 'app_offre_show', requirements: ['offreId' => '\d+'])]
    public function show(
        #[MapEntity(class: 'App\Entity\Offre', expr: 'repository.findById(offreId)')]
        Offre $Offre,
        int $offreId,
        Security $security): Response
    {
        $Inscrit = $this->inscrireRepository->IsInscrit($offreId, $security);

        $skills = $this->skillDemanderRepository->getSkillLibellesByOffreId($offreId);

        $nbInscriptionAccepter = $this->offreRepository->getNbInscriptionsAccepter([$Offre]);


        return $this->render('offre/show.html.twig',[
            'Offre'=>$Offre,
            'inscription' => $Inscrit,
            'skills' => $skills,
            'nbInscriptionAccepter' => $nbInscriptionAccepter
        ]);
    }
}