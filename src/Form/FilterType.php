<?php

namespace App\Form;

use App\Entity\Campus;
use App\Form\Models\FilterModel;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('campus', EntityType::class, [
                'label' => 'Campus :',
                'class' => Campus::class,
                'choice_label' => 'name',
                'placeholder' =>'-- Tous les campus --',
                'required' => false
            ])
            ->add('contains', TextType::class, [
                'label' => 'Le nom de la sortie contient : ',
                'required' => false
            ])
            ->add('dateStartTime', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Entre :',
                'input' => 'datetime_immutable',
                'required' => false
            ])
            ->add('dateEndTime', DateType::class, [
                'widget' => 'single_text',
                'label' => ' et ',
                'input' => 'datetime_immutable',
                'required' => false
            ])
            ->add('isOrganizer', CheckboxType::class, [
                'label' => 'Sorties dont je suis l\'organisateur(trice)',
                'required' => false
            ])
            ->add('isRegisteredTo', CheckboxType::class, [
                'label' => 'Sorties auxquelles je suis inscrit(e)',
                'required' => false
            ])
            ->add('isNotRegisteredTo', CheckboxType::class, [
                'label' => 'Sorties auxquelles je ne suis PAS inscrit(e)',
                'required' => false
            ])
            ->add('isPassed', CheckboxType::class, [
                'label' => 'Sorties passées',
                'required' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'date_class' => FilterModel::class
        ]);
    }
}
