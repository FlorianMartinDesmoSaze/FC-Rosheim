<?php

namespace App\Form;

use App\Entity\Team;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class TeamType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('teamName', TextType::class, [
                'label' => 'Nom de l\'équipe',
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
            ->add('season', TextType::class, [
                'label' => 'Saison',
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
            ->add('picture', FileType::class, [
                'label' => 'Photo de l\'équipe',
                'attr' => [
                    'class' => 'form-control',
                ],
                // make it optional so you don't have to re-upload the PDF file
                // every time you edit the Product details
                'required' => false,
                // unmapped fields can't define their validation using annotations
                // in the associated entity, so you can use the PHP constraint classes
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'application/jpg',
                            'application/jpeg',
                            'application/png',
                        ],
                        'mimeTypesMessage' => 'Veuillez insérer une image valide',
                    ])
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Team::class,
        ]);
    }
}
