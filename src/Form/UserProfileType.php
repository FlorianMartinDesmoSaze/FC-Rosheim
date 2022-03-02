<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;

class UserProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => 'Email',
                'required' => true,
                'attr' => ['class' => 'form-control'],
            ])
            ->add('nickname', TextType::class, [
                'label' => 'Pseudonyme*',
                'attr' => ['class' => 'form-control'],
            ])
            ->add('phone', TelType::class, [
                'label' => 'Numéro de téléphone*',
                'attr' => ['class' => 'form-control'],
            ])
            ->add('lastName', TextType::class, [
                'label' => 'Nom*',
                'attr' => ['class' => 'form-control'],
            ])
            ->add('first_name', TextType::class, [
                'label' => 'Prénom*',
                'attr' => ['class' => 'form-control'],
            ])
            ->add('birthdate', BirthdayType::class, [
                'label' => 'Date de naissance*',
                'years' => range(date('Y'), date('Y') - 100),
                'format' => 'dd-MM-yyyy'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
