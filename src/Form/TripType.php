<?php

namespace App\Form;

use App\Entity\Campus;
use App\Entity\City;
use App\Entity\Place;
use App\Entity\Trip;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TripType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom'
            ])
            ->add('dateStartTime', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Date de début de la sortie',
                'input' => 'datetime_immutable'
             ])
            ->add('duration', IntegerType::class, [
                'label' => 'Durée (en minutes)',
                'attr' => [
                    'min' => 30,
                    'placeholder' => '30 minutes minimum'
                ]
            ])
            ->add('registrationDeadLine', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Date limite d\'inscription',
                'input' => 'datetime_immutable'
            ])
            ->add('nbRegistrationsMax', IntegerType::class, [
                'label' => 'Participants maximum',
                'attr' => [
                    'min' => 2
                ]
            ])
            ->add('infosTrip', TextareaType::class, [
                'label' => 'Description de la sortie'
            ])
            ->add('campus', EntityType::class, [
                'label' => 'Campus',
                'class' => Campus::class,
                'choice_label' => 'name',
                'placeholder' =>'-- Choisir un campus --'
            ])
            ->add('place', EntityType::class, [
                'label' => 'Lieu',
                'class' => Place::class,
                'choice_label' => 'name',
                'placeholder' =>'-- Choisir un lieu --'
            ]);
//            ->add('publish', SubmitType::class, [
//                'label' =>'Publish'
//            ])
//            ->add('register', SubmitType::class, [
//                'label' =>'Save',
//                'attr' => [
//                    'class' => 'btn btn-warning'
//                ]
//            ])
//            ->add('delete',SubmitType::class, [
//                'label' => 'Delete',
//                'attr' => [
//                    'class' => 'btn btn-danger'
//                ]
//            ])
//        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Trip::class,
        ]);
    }
}
