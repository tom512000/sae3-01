<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TelephoneField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class UserCrudController extends AbstractCrudController
{
    /**
     * Retourne le nom de la classe de l'entité gérée par ce contrôleur.
     *
     * @return string Le nom de la classe de l'entité
     */
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    /**
     * Configure les champs à afficher dans les différentes pages de l'interface d'administration.
     *
     * @param string $pageName Le nom de la page actuelle (list, edit, new, show, etc.)
     *
     * @return iterable La configuration des champs
     */
    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('firstName', 'Nom de famille'),
            TextField::new('lastName', 'Prénom'),
            TelephoneField::new('phone', 'Numéro de Téléphone'),
            DateField::new('dateNais', 'Date de Naissance'),
            EmailField::new('email', 'Adresse Mail'),
            ArrayField::new('roles')
                ->formatValue(function ($value) {
                    if ($value == ['ROLE_USER']) {
                        return 'Utilisateur';
                    } else {
                        return 'Admin';
                    }
                }),
        ];
    }
}
