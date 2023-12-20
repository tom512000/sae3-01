<?php

namespace App\Controller\Admin;

use App\Entity\Offre;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class OffreCrudController extends AbstractCrudController
{
    /**
     * Retourne le nom de la classe de l'entité gérée par ce contrôleur.
     *
     * @return string Le nom de la classe de l'entité
     */
    public static function getEntityFqcn(): string
    {
        return Offre::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id', 'ID')->onlyOnIndex(),
            TextField::new('nomOffre', 'Nom du poste'),
            IntegerField::new('duree', 'Durée (j)'),
            TextField::new('lieux', 'Adresse'),
            DateField::new('jourDeb', 'Date de Début'),
            IntegerField::new('nbPlace', 'Places'),
            TextField::new('descrip', 'Description'),
            TextField::new('level', 'Niveau Recherché'),
            AssociationField::new('Type', 'Type')->setFormTypeOptions([
                'choice_label' => 'libelle'])->formatValue(function ($value, $entity) {
                    if (null != $entity->getType()->getLibelle()) {
                        return $entity->getType()->getLibelle();
                    } else {
                        return 'Aucun';
                    }
                }),
        ];
    }
}
