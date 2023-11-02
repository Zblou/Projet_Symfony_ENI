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
                'label' => 'Date de début'
            ])
            ->add('duration', IntegerType::class, [
                'label' => 'Durée'
            ])
            ->add('registrationDeadLine', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Date limite d\'inscription'
            ])
            ->add('nbRegistrationsMax', IntegerType::class, [
                'label' => 'Durée'
            ])
            ->add('infosTrip', TextType::class, [
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
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Trip::class,
        ]);
    }
}
