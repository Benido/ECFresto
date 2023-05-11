<?php

namespace App\Form;

use App\Entity\Allergen;
use App\Entity\Client;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class ClientPreferencesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class)
            ->add('newPassword', PasswordType::class,
            [
                'required' => false,
                'always_empty'=> true,
                'mapped' => false,
                /*
                'constraints' => [
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Votre mot de passe doit comporter au moins {{ limit }} caractères',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
                */
                'attr' => ['autocomplete' => 'new-password']
            ])
            ->add('newPasswordConfirmation', PasswordType::class,
            [
                'required' => false,
                'mapped'=>false,
                /*
                'constraints' => [
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Votre mot de passe doit comporter au moins {{ limit }} caractères',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
                */
                'attr' => ['autocomplete' => 'new-password']
            ])
            ->add('defaultSeatsNumber',
                ChoiceType::class,
                [
                    'required' => false,
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
            ->add('allergens',
                EntityType::class,
                [
                    'class' => Allergen::class,
                    'choice_label' => 'title',
                    'multiple' => true,
                    'expanded' => true
                ]
            )
            ->add('submit', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Client::class,
            'client' => null,
        ]);
    }
}
