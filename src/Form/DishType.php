<?php

namespace App\Form;

use App\Entity\Allergen;
use App\Entity\Dish;
use App\Entity\DishCategory;
use App\Entity\Menu;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DishType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('description')
            ->add('price')
            ->add('category', EntityType::class,
                [
                    'class' => DishCategory::class,
                    'choice_label' => 'title',
                ]
            )
            ->add('menus', EntityType::class,
                [
                    'class' => Menu::class,
                    'choice_label' => 'title',
                    'multiple' => true,
                ]
            )
            ->add('allergens', EntityType::class,
                [
                    'class' => Allergen::class,
                    'choice_label' => 'title',
                    'multiple' => true,
                    'expanded' => true,
                ]
            )
            ->add('submit',SubmitType::class, ['label' => 'Enregistrer'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Dish::class,
        ]);
    }
}
