<?php

namespace App\Form;

use App\Entity\Campus;
use App\Entity\Participant;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MyProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('pseudo', TextType::class, [
                'label' => 'Pseudo'
            ])
            ->add('firstname', TextType::class,[
                'label' => 'Firstname'
            ])
            ->add('name', TextType::class,[
                'label' => 'Name'
            ])
            ->add('phone',TextType::class,[
                'label' => 'Phone number'
            ])
            ->add('mail', EmailType::class, [
                'label' => 'Mail'
            ])
            ->add('password', PasswordType::class, [
                'label' => 'Password'
            ])/*
            ->add('passwordConfirm', PasswordType::class, [
                'label' => 'Confirm Password'
            ])*/
            ->add('campus', EntityType::class,[
                'label'=> 'Campus',
                'class' => Campus::class,
                'choice_label' => 'name',
                'placeholder' => '--Choose a campus--'
            ])
            ->add('photoURL',FileType::class,[
                'label' => 'My Picture',
                'required' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Participant::class,
        ]);
    }
}
