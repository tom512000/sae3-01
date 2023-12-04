<?php

namespace App\Controller;

use App\Entity\Offre;
use App\Repository\InscrireRepository;
use Doctrine\ORM\NonUniqueResultException;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
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

    /**
     * @throws NonUniqueResultException
     */
    #[Route('/inscription/{idOffre}', name: 'app_inscire_inscription', requirements: ['idOffre' => '\d+'])]
    public function inscription(
        #[MapEntity(class: 'App\Entity\Offre', expr: 'repository.find(idOffre)')]
        Offre $offre,
        InscrireRepository $inscrireRepository,
        Security $security
    ): Response {
        $inscrireRepository->inscription($offre, $security);

        return $this->redirectToRoute('app_inscire');
    }

    /**
     * @throws NonUniqueResultException
     */
    #[Route('/desinscription/{idOffre}', name: 'app_inscire_desinscription', requirements: ['idOffre' => '\d+'])]
    public function desinscription(
        #[MapEntity(class: 'App\Entity\Offre', expr: 'repository.find(idOffre)')]
        Offre $offre,
        InscrireRepository $inscrireRepository,
        Security $security
    ): Response {
        $inscrireRepository->desinscription($offre, $security);

        return $this->redirectToRoute('app_inscire');
    }
}
