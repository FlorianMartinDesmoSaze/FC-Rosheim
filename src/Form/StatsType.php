<?php

namespace App\Form;

use App\Entity\Stats;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StatsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('gamePlayed')
            ->add('cleanSheets')
            ->add('saves')
            ->add('assists')
            ->add('goals')
            ->add('yellowCards')
            ->add('redCards')
            ->add('player')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Stats::class,
        ]);
    }
}
