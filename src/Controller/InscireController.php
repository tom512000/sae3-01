<?php

namespace App\Controller;

use App\Repository\InscrireRepository;
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

            return $this->render('inscire/index.html.twig', [
                'inscriptions' => $inscriptions,
            ]);
        } else {
            return $this->redirectToRoute('app_login');
        }
    }
}
