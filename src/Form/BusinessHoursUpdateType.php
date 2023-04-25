<?php

namespace App\Form;

use App\Entity\BusinessHours;
use App\Enum\Weekdays;
use App\Form\BusinessHoursFormType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BusinessHoursUpdateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->
            add(
                'BusinessHoursFormType',
                CollectionType::class,
                [
                    'entry_type' => BusinessHoursFormType::class,
                    'label' => false,
                    'entry_options' => ['label' => false],
                    'allow_add' => true,
                    'allow_delete' => true,
                ])
            ->add('enregistrer', SubmitType::class);
    }
/*
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => BusinessHours::class,
        ]);
    }
*/
}