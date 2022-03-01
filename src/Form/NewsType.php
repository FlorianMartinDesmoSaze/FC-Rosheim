<?php

namespace App\Form;

use App\Entity\News;
use App\Entity\Team;
use App\Entity\Event;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class NewsType extends AbstractType
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
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => News::class,
        ]);
    }
}
