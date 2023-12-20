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

class InscrireController extends AbstractController
{
    /**
     * Affiche la liste des inscriptions de l'utilisateur connecté.
     *
     * @param InscrireRepository $inscrireRepository Le repository des inscriptions
     * @param Security           $security           Le service de sécurité Symfony
     *
     * @return Response La réponse HTTP de la liste des inscriptions
     */
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
     * Inscrit l'utilisateur à une offre spécifique.
     *
     * @param Offre              $offre              L'offre à laquelle l'utilisateur souhaite s'inscrire
     * @param InscrireRepository $inscrireRepository Le repository des inscriptions
     * @param Security           $security           Le service de sécurité Symfony
     *
     * @return Response La réponse HTTP de l'inscription
     *
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
     * Désinscrit l'utilisateur d'une offre spécifique.
     *
     * @param Offre              $offre              L'offre dont l'utilisateur souhaite se désinscrire
     * @param InscrireRepository $inscrireRepository Le repository des inscriptions
     * @param Security           $security           Le service de sécurité Symfony
     *
     * @return Response La réponse HTTP de la désinscription
     *
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
