<?php

namespace App\Form;

use App\Entity\User;
use Doctrine\DBAL\Types\StringType;
use phpDocumentor\Reflection\Types\String_;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstName',null,['label' => 'Nom'])
            ->add('lastName',null,['label' => 'Prénom'])
            ->add('phone',null,['label' => 'Numéro de Téléphone'])
            ->add('dateNais',null,['label' => 'Date de Naissance'])
            ->add('email',null,['label' => 'Adresse Email'])
            ->add('cv', FileType::class, [
                'label' => 'cv (PDF)', 'mapped' => false,'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '9024k',
                        'mimeTypes' => [
                            'application/pdf',
                            'application/x-pdf',
                        ],
                        'mimeTypesMessage' => 'Veuillez uploader un pdf valide',
                    ])
                ],
            ])
            ->add('lettreMotiv', FileType::class, [
                'label' => 'Lettre de Motivation (PDF)', 'mapped' => false,'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '9024k',
                        'mimeTypes' => [
                            'application/pdf',
                            'application/x-pdf',
                        ],
                        'mimeTypesMessage' => 'Veuillez uploader un pdf valide',
                    ])
                ],
            ])
            ->add('save', SubmitType::class, ['label' => 'Sauvegarder'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
