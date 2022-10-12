<?php

namespace App\Form;

use App\Entity\Event;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class NewEventType extends AbstractType
{


    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('description')
            ->add('user')
            ->add('type',ChoiceType::class, [
                'choices' => ['Événement sportif'=>Event::EVT_SPORT,'Événement associatif'=>Event::EVT_ASSO]])
            ->add('startDate', DateTimeType::class, [
                'data' => new \DateTimeImmutable(),
                'html5' => false,
                'with_seconds' => false,
                'format' => DateTimeType::DEFAULT_DATE_FORMAT
            ])
            ->add('endDate', DateTimeType::class, [
                'data' => new \DateTimeImmutable(),
                'html5' => false,
                'with_seconds' => false,
                'format' => DateTimeType::DEFAULT_DATE_FORMAT
            ])
            ->add('location')


        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
        ]);
    }
}
