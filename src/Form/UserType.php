<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

/**
 * Classe définissant le formulaire de saisie des informations utilisateur.
 */
class UserType extends AbstractType
{
    /**
     * Construit le formulaire avec les champs nécessaires.
     *
     * @param FormBuilderInterface $builder le constructeur de formulaire
     * @param array                $options les options du formulaire
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstName', null, [
                'label' => 'Nom',
            ])
            ->add('lastName', null, [
                'label' => 'Prénom',
            ])
            ->add('phone', TelType::class, [
                'label' => 'Numéro de Téléphone',
            ])
            ->add('dateNais', BirthdayType::class, [
                'label' => 'Date de Naissance',
            ])
            ->add('email', EmailType::class, [
                'label' => 'Adresse Email',
            ])
            ->add('password', PasswordType::class, [
                'label' => 'Mot de Passe',
            ])
            ->add('cv', FileType::class, [
                'label' => 'cv (PDF)',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '9024k',
                        'mimeTypes' => [
                            'application/pdf',
                            'application/x-pdf',
                        ],
                        'mimeTypesMessage' => 'Veuillez uploader un pdf valide',
                    ]),
                ],
            ])
            ->add('lettreMotiv', FileType::class, [
                'label' => 'Lettre de Motivation (PDF)',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '9024k',
                        'mimeTypes' => [
                            'application/pdf',
                            'application/x-pdf',
                        ],
                        'mimeTypesMessage' => 'Veuillez uploader un pdf valide',
                    ]),
                ],
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Sauvegarder',
            ])
        ;
    }

    /**
     * Configure les options du formulaire.
     *
     * @param OptionsResolver $resolver le résolveur d'options
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
