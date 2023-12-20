<?php

namespace App\Controller\Admin;

use App\Entity\Entreprise;
use App\Entity\Offre;
use App\Entity\Skill;
use App\Entity\Type;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_ADMIN')]
class DashboardController extends AbstractDashboardController
{
    /**
     * Affiche le tableau de bord de l'administration.
     *
     * @return Response La réponse HTTP du tableau de bord
     */
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        return $this->render('admin/index.html.twig');
    }

    /**
     * Configure les paramètres du tableau de bord.
     *
     * @return Dashboard La configuration du tableau de bord
     */
    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()->setTitle('EduTech Dashboard');
    }

    /**
     * Configure les éléments du menu de l'interface d'administration.
     *
     * @return iterable Une collection d'éléments de menu EasyAdmin
     */
    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Entreprises', 'fas fa-list', Entreprise::class);
        yield MenuItem::linkToCrud('Offres', 'fas fa-list', Offre::class);
        yield MenuItem::linkToCrud('Utilisateurs', 'fas fa-list', User::class);
        yield MenuItem::linkToCrud('Compétences', 'fas fa-list', Skill::class);
        yield MenuItem::linkToCrud('Types', 'fas fa-list', Type::class);
        yield MenuItem::linkToUrl('Accueil', 'fa fa-home', '/');
    }
}
