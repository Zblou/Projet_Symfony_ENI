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
                'placeholder' =>'-- Choisir un campus --'
            ])
            ->add('contains', TextType::class, [
                'label' => 'Le nom de la sortie contient : '
            ])
            ->add('dateStartTime', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Entre :',
                'input' => 'datetime_immutable'
            ])
            ->add('dateEndTime', DateType::class, [
                'widget' => 'single_text',
                'label' => ' et ',
                'input' => 'datetime_immutable'
            ])
            ->add('isOrganizer', CheckboxType::class, [
                'label' => 'Sorties dont je suis l\'organisateur(trice)'
            ])
            ->add('isRegisteredTo', CheckboxType::class, [
                'label' => 'Sorties auxquelles je suis inscrit(e)'
            ])
            ->add('isNotRegisteredTo', CheckboxType::class, [
                'label' => 'Sorties auxquelles je ne suis PAS inscrit(e)'
            ])
            ->add('isPassed', CheckboxType::class, [
                'label' => 'Sorties passées'
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
