<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            'firstName',
            'lastName',
            'phone',
            'status',
            'dateNais',
            'email',
            ArrayField::new('roles')
                ->formatValue(function ($value) {
                    if ($value == 'ROLE_USER'){
                        return 'Utilisateur';
                    }
                    else{
                        return 'Admin';
                    }
                })
        ];
    }

}
