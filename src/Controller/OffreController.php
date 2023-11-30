<?php

namespace App\Controller;

use App\Entity\Offre;
use App\Entity\Type;
use App\Repository\InscrireRepository;
use App\Repository\OffreRepository;
use App\Repository\TypeRepository;
use Doctrine\ORM\NonUniqueResultException;
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
    /**
     * @param OffreRepository $offreRepository
     * @param Request $request
     * @param TypeRepository $typeRepository
     * @param InscrireRepository $inscrireRepository
     * @param Security $security
     * @param array $Offres
     * @return Response
     * @throws \Exception
     */
    #[Route('/offre', name: 'app_offre_index')]
    public function index(OffreRepository $offreRepository,
                          Request $request,
                          TypeRepository $typeRepository,
                          InscrireRepository $inscrireRepository,
                          Security $security): Response
    {
        $textRechercher = $request->query->get('textRecherche', '');
        $typeRechercher = $request->query->get('type', 0);
        $niveauRechercher = (int) $request->query->get('niveau', -1);
        $dateRechercher = $request->query->get('date', '');
        $dateFiltreRechercher = $request->query->get('dateFiltre', 0);

        $Offres = $offreRepository->findByFilter($typeRechercher, $textRechercher, $niveauRechercher, $dateRechercher, $dateFiltreRechercher);

        $types = $typeRepository->findAll();

        $inscription = $inscrireRepository->getInscriptions($Offres, $security);


        return $this->render('offre/index.html.twig', [
            'Offres'=>$Offres,
            'textRecherche' => $textRechercher,
            'types' => $types,
            'inscription' => $inscription
        ]);
    }

    /**
     * @throws NonUniqueResultException
     */
    #[Route('/entreprise/offre', name: 'app_offre_OffreEntreprise', requirements: ['entrepriseId' => '\d+'])]
    public function OffreEntreprise(OffreRepository $offreRepository, Request $request, TypeRepository $typeRepository, InscrireRepository $inscrireRepository, Security $security): Response
    {
        $textRechercher = $request->query->get('textRecherche', '');
        $typeRechercher = $request->query->get('type', 0);
        $entrepriseId = $request->query->get('entrepriseId');
        $niveauRechercher = (int) $request->query->get('niveau', -1);;
        $dateRechercher = $request->query->get('date', '');
        $dateFiltreRechercher = $request->query->get('dateFiltre', 0);

        $Offres = $offreRepository->findByFilterByEntrepriseId($entrepriseId,$typeRechercher, $textRechercher, $niveauRechercher, $dateRechercher, $dateFiltreRechercher);
        $types = $typeRepository->findAll();

        $nbOffres = $offreRepository->findNbOffreByEntreprise($entrepriseId);

        $inscription = $inscrireRepository->getInscriptions($Offres, $security);

        return $this->render('entreprise/offre/index.html.twig', [
            'types' => $types,
            'textRecherche' => $textRechercher,
            'Offres'=>$Offres,
            'entrepriseId' => $entrepriseId,
            'nbOffres' => $nbOffres,
            'inscription' => $inscription
        ]);
    }

    #[Route('/offre/{offreId}', name: 'app_offre_show', requirements: ['offreId' => '\d+'])]
    public function show(
        #[MapEntity(class: 'App\Entity\Offre', expr: 'repository.find(offreId)')]
        Offre $Offre,
        int $offreId,
        InscrireRepository $inscrireRepository,
        Security $security): Response
    {
        $Inscrit = $inscrireRepository->IsInscrit($offreId, $security);
        return $this->render('offre/show.html.twig',[
            'Offre'=>$Offre,
            'inscription' => $Inscrit
        ]);
    }
}
