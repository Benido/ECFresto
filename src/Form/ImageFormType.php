<?php

namespace App\Form;

use App\Entity\Image;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Form\Type\VichImageType;

class ImageFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('imageFile', VichImageType::class, [
                'required' => false,  //pour ne pas redemander un upload du fichier pour une simple édition
                'image_uri' => false,
                'download_uri' => false,
                'constraints' => [new  Assert\File([
                    'maxSize' => '4096k',
                    'maxSizeMessage' => 'La taille maximum autorisée pour une image est de 2 MO',
                    'uploadErrorMessage' => 'Une erreur est survenue lors du chargement',
                    'mimeTypes' => [
                        'image/jpeg',
                        'image/png',
                        'image/webp'
                    ],
                    'mimeTypesMessage' => 'Format non-autorisé. Les types autorisés sont "jpeg", "png" et "webp"'
                ])]
            ])
            ->add('title')
            ->add('submit', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Image::class,
        ]);
    }
}
