<?php

namespace App\Form;

use App\Entity\Game;
use App\Entity\Team;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class GameType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('opponent', TextType::class, [
                'label' => 'Prénom',
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
            ->add('scoreTeam', IntegerType::class, [
                'label' => 'Prénom',
                'mapped' => false,
                'required' => false,
                'attr' => [
                    'class' => 'form-control',
                    'min' => 0
                ],
            ])
            ->add('scoreOpponent', IntegerType::class, [
                'label' => 'Prénom',
                'mapped' => false,
                'required' => false,
                'attr' => [
                    'class' => 'form-control',
                    'min' => 0
                ],
            ])
            ->add('gameDate', DateTimeType::class, [
                'label' => 'Date du match',
                'with_seconds' => false,
            ])
            ->add('home', CheckboxType::class, [
                'label' => 'À domicile ?',
                'required' => false,
            ])
            ->add('team', EntityType::class, [
                'label' => 'Équipe',
                'class' => Team::class,
                'choice_label' => 'teamName',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Game::class,
        ]);
    }
}
