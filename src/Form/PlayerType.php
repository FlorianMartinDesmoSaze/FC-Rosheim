<?php

namespace App\Form;

use App\Entity\Player;
use Symfony\Component\Form\AbstractType;
// use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Doctrine\DBAL\Types\DateType;

class PlayerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstName')
            ->add('lastName')
            ->add('number')
            ->add('birthdate', null, [
                'widget' => 'choice',
                'years' => range(date('Y'), date('Y') - 100),
                'placeholder' => [
                    'year' => 'Year', 'month' => 'Month', 'day' => 'Day',
                ],
                // 'months' => range(date('m'), 12),
                // 'days' => range(date('d'), 31),
            ])
            ->add('picture')
            ->add('slug')
            ->add('team')
            ->add('position')
            ->add('stats');
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Player::class,
        ]);
    }
}
