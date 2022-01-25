<?php

namespace App\Form;

use App\Entity\Event;
<<<<<<< HEAD
use App\Entity\News;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class EventType extends AbstractType
{
    
    
=======
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EventType extends AbstractType
{
>>>>>>> a1920ecdde4ff5ba76bb484d72b659e6873da99c
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('description')
<<<<<<< HEAD
            //->add('type')
            //->add('type', EntityType::class,['class'=>Event::class,'choice_label'=>'type','expanded' => true,] )
            ->add('type',ChoiceType::class, [
                'choices' => ['evenement sportif'=>Event::EVT_SPORT,'evenement associatif'=>Event::EVT_ASSO]])
            ->add('startDate')
            ->add('endDate')
            ->add('location')

             
=======
            ->add('type')
            ->add('startDate')
            ->add('endDate')
            ->add('location')
            ->add('slug')
            ->add('news')
            ->add('user')
>>>>>>> a1920ecdde4ff5ba76bb484d72b659e6873da99c
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
        ]);
    }
}
