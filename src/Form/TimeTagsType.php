<?php

namespace App\Form;

use App\Service\AvailableReservationDateGetter;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TimeTagsType extends AbstractType
{
    public function __construct(private AvailableReservationDateGetter $availableReservationDateGetter){}

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'time',
                ChoiceType::class,
                [
                    'choices' => $this->availableReservationDateGetter->getAvailableReservationDate($options['day']),
                    'expanded' => true,
                ]
            )
            ->addModelTransformer(new CallbackTransformer(
                function($dateTimeToArray){
                    return [$dateTimeToArray->format('H:i')];
                },
                function($arrayToDateTime){
                    return new \Datetime($arrayToDateTime['time']);
                },
            ));
    }
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'day' => null,

        ]);
    }
}