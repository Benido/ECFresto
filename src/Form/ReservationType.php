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
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use DateTime;

class ReservationType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('seats_number',
                ChoiceType::class,
                [
                    //S'il est connecté, on récupère le nombre de couverts par défaut du client
                    'data' => $options['client']?->getDefaultSeatsNumber(),
                    'choices'=> [
                        '1 couvert' => 1,
                        '2 couverts' => 2,
                        '3 couverts' => 3,
                        '4 couverts' => 4,
                        '5 couverts' => 5,
                        '6 couverts' => 6,
                        '7 couverts' => 7,
                        '8 couverts' => 8
                    ]
                ]
            )
            ->add('day',
                DateType::class,
                [
                    'property_path' => 'day',
                    'widget' => 'single_text',
                ]
            )
            ->add('email',
                EmailType::class,
                [
                    //S'il est connecté, on récupère l'email du client
                    'data' => $options['client']?->getEmail() ,
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
                'submit',SubmitType::class
            )
            ->add('reset', ResetType::class)
        ;

        //Modificateur qui ajoute le champ montrant les créneaux horaires disponibles
        $formModifier = function(FormInterface $form, \DateTime $day, int $seats) {
            $form->add('date', TimeTagsType::class,
            [
                'label'=> false,
                'day' => $day,
                'seats' => $seats,
            ]);
        };

        //On ajoute le champ avec les données pré-inscrites
        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) use ($formModifier) {
                $data = $event->getData();
                $formModifier($event->getForm(), $data->getDay(), $data->getSeatsNumber());
            }
        );

        //On récupère les données entrées par l'utilisateur grâce à la requête Ajax
        // lancée par le contrôleur Javascript time-slot-controller
        $builder->addEventListener(
            FormEvents::PRE_SUBMIT,
            function (FormEvent $event) use ($formModifier) {
                $data = $event->getData();
                //On formate les données dans le format attendu par les propriétés correspondantes de l'Entité Réservation
                $day = new \DateTime($data['day']);
                $seats = $data['seats_number'];

                //On remplace les valeurs des champs correspondants pour que le formulaire soit soumis au contrôleur PHP ReservationController
                $formModifier($event->getForm(), $day, $seats);
            }
        );

        $builder->addEventListener(
            FormEvents::SUBMIT,
            function (FormEvent $event) use ($formModifier) {
                $data = $event->getData();
                dump($data);
            }
        );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reservation::class,
            'restaurant' => null,
            'client' => null,
            'attr' => ['id' => 'reservation_form'],
        ]);
    }
}
