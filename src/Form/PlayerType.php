<?php

namespace App\Form;

use App\Entity\Team;
use App\Entity\Player;
use App\Entity\Position;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class PlayerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstName', TextType::class, [
                'label' => 'Prénom',
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
            ->add('lastName', TextType::class, [
                'label' => 'Nom',
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
            ->add('number', IntegerType::class, [
                'label' => 'Numéro',
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
            ->add('birthdate', DateType::class, [
                'widget' => 'single_text',
            ])
            ->add('picture', FileType::class, [
                'label' => 'Photo du joueur',
                'attr' => [
                    'class' => 'form-control',
                ],
                // make it optional so you don't have to re-upload the PDF file
                // every time you edit the Product details
                'required' => false,
                'data_class' => null,
                // unmapped fields can't define their validation using annotations
                // in the associated entity, so you can use the PHP constraint classes
                'constraints' => [
                    new File([
                        'maxSize' => '1000k',
                        'mimeTypes' => [
                            'image/jpg',
                            'image/jpeg',
                            'image/png',
                            'image/webp',
                        ],
                    ])
                ],
            ])
            ->add('team', EntityType::class, [
                'label' => 'Équipe',
                // looks for choices from this entity
                'class' => Team::class,
                'choice_label' => 'teamName',
            ])
            ->add('position', EntityType::class, [
                'label' => 'Équipe',
                'class' => Position::class,
                'choice_label' => 'name',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Player::class,
        ]);
    }
}
