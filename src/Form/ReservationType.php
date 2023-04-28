<?php

namespace App\Form;

use App\Entity\Client;
use App\Entity\Reservation;
use App\Entity\Restaurant;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReservationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
                ->add('day',
                    DateType::class,
                    [
                        'property_path' => 'day',
                        'widget' => 'single_text',
                    ]
                )
                ->add('time',
                    TimeType::class,
                    [
                        'property_path' => 'time',
                        'input_format' => 'H:i'
                    ]
                )
            ->add('email',
                EmailType::class,
                [
                    //S'il est connecté, on récupère l'email du client
                    'data' => $options['client']?->getEmail() ,
                ]
            )
            ->add('seats_number',
                ChoiceType::class,
                [
                    //S'il est connecté, on récupère le nombre de couverts par défaut du client
                    'data' => $options['client']?->getDefaultSeatsNumber(),
                    'choices'=> [
                        '1' => 1,
                        '2' => 2,
                        '3' => 3,
                        '4' => 4,
                        '5' => 5,
                        '6' => 6,
                        '7' => 7,
                        '8' => 8
                    ]
                ]
            )
            ->add(
                $builder
                    ->create('allergens',
                TextType::class,
                        [
                            'required' => false,
                            //S'il est connecté, on récupère les allergènes sauvegardés par le client
                            'data' => $options['client']?->getAllergens(),
                        ])
                    ->addModelTransformer(new CallbackTransformer(
                        function ($allergensAsArray): string {
                            return $allergensAsArray ? implode(', ', $allergensAsArray) : "";
                        }    ,
                        function ($allergensAsString): array {
                            return $allergensAsString ? explode(', ', $allergensAsString) : [];
                        }
                    ))
            )
            ->add('comment',
                TextareaType::class,
                [
                    'required' => false,
                ]
            )
            ->add(
                'restaurant',
                EntityType::class,
                [
                    'class' => Restaurant::class,
                    'choice_label' => 'displayName',
                    'data' => $options['restaurant'],
                    'attr' => ['hidden' => ''],
                    'label' => false
                ]
            )
            ->add('client',
                EntityType::class,
                [
                    'required' => false,
                    'class' => Client::class,
                    'choice_label' => 'displayName',
                    'data' => $options['client']?? null,
                    'attr' => ['hidden' => ''],
                    'label' => false
                ]
            )
            ->add(
                'submit',
                SubmitType::class
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reservation::class,
            'restaurant' => null,
            'client' => null,
        ]);
    }
}
