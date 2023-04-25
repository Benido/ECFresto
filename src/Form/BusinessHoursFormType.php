<?php

namespace App\Form;

use App\Entity\BusinessHours;
use App\Enum\Weekdays;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BusinessHoursFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'weekday',
                EnumType::class,
                ['class' => Weekdays::class,
                 'label' => false,
                 'attr' => [
                     'class' => 'weekday',
                     'hidden' => ''
                 ]
                ]
            )
            ->add(
                'openingHour',
                TimeType::class,
                    [
                    'input' => 'datetime',
                    'widget' => 'choice',
                    'data' => new \DateTime('7:00'),
                    'minutes'=> ['00', '15', '30', '45'],
                    'label' => 'heure d\'ouverture',
                    'attr' => ['class' => 'select']
                    ]
            )
            ->add(
                'closingHour',
                TimeType::class,
                    [
                    'input' => 'datetime',
                    'widget' => 'choice',
                        'data' => new \DateTime('15:00'),
                    'minutes'=> ['00', '15', '30', '45'],
                    'label' => 'heure de fermeture',
                    'attr' => ['class' => 'select']
                    ]
                )
            /*
            ->add(
                'isClosed',
                CheckboxType::class,
                [
                    'mapped' => false,
                    'required' => false,
                    'label' => 'fermé toute la journée',
                    'attr' => ['class' => 'isClosed']
                ]
            )
            */
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => BusinessHours::class,
        ]);
    }
}

