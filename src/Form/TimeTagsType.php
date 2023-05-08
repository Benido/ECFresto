<?php

namespace App\Form;

use App\Service\AvailableReservationDateGetter;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TimeTagsType extends AbstractType
{
    public function __construct(private AvailableReservationDateGetter $availableReservationDateGetter){}

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'date',
                ChoiceType::class,
                [
                    'choices' => $this->availableReservationDateGetter->getAvailableReservationDate($options['day'], $options['seats']),
                    'expanded' => true,
                ]
            )
            ->addModelTransformer(new CallbackTransformer(
                function($dateTimeToArray){
                    return [$dateTimeToArray];
                },
                function($arrayToDateTime){
                    return ($arrayToDateTime['date']);
                },
            ));
    }
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'day' => null,
            'seats' => null,

        ]);
    }
}