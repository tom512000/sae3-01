<?php

namespace App\Controller\Admin;

use App\Entity\Entreprise;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class EntrepriseCrudController extends AbstractCrudController
{
    /**
     * Retourne le nom de la classe de l'entité gérée par ce contrôleur.
     *
     * @return string Le nom de la classe de l'entité
     */
    public static function getEntityFqcn(): string
    {
        return Entreprise::class;
    }
}
