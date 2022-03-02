<?php

namespace App\Form;

use App\Entity\Event;
use App\Entity\News;
use App\Entity\Team;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class AdminNewsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre',
                'attr' => [
                    'class' => 'form-control',
                ]
            ])
            ->add('content', TextareaType::class, [
                'label' => 'Titre',
                'attr' => [
                    'class' => 'form-control',
                ]
            ])
            ->add('picture', FileType::class, [
                'label' => 'Photo illustrative',
                'attr' => [
                    'class' => 'form-control',
                ],
                'required' => false,
                'data_class' => null,
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
                'class' => Team::class,
                'choice_label' => 'teamName',
            ])
            ->add('event', EntityType::class, [
                'label' => 'Évènement',
                'class' => Event::class,
                'choice_label' => 'title',
            ])
            ->add('user')
            ->add('createdAt')
            ->add('id')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => News::class,
        ]);
    }
}
