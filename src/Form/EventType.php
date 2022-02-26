<?php

namespace App\Form;

use App\Entity\Event;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class EventType extends AbstractType
{
    
    
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('description')
            //->add('type')
            //->add('type', EntityType::class,['class'=>Event::class,'choice_label'=>'type','expanded' => true,] )
            ->add('type',ChoiceType::class, [
                'choices' => ['Événement sportif'=>Event::EVT_SPORT,'Événement associatif'=>Event::EVT_ASSO]])
            ->add('startDate')
            ->add('endDate')
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
