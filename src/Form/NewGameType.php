<?php

namespace App\Form;

use App\Entity\Game;
use App\Entity\Team;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NewGameType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('opponent', TextType::class, [
                'label' => 'Adversaire',
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
            ->add('scoreTeam', IntegerType::class, [
                'label' => 'Score de l\'équipe',
                'required' => false,
                'attr' => [
                    'class' => 'form-control',
                    'min' => 0
                ],
            ])
            ->add('scoreOpponent', IntegerType::class, [
                'label' => 'Score de l\'adversaire',
                'required' => false,
                'attr' => [
                    'class' => 'form-control',
                    'min' => 0
                ],
            ])
            ->add('gameDate', DateTimeType::class, [
                'label' => 'Date du match',
                'data' => new \DateTimeImmutable(),
                'html5' => false,
                'with_seconds' => false,
                'format' => DateTimeType::DEFAULT_DATE_FORMAT
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
