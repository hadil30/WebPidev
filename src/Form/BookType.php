<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints as Assert;
use App\Entity\Books;

class BookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nomLiv', TextType::class, [
                'label' => 'nomLiv',
                'attr' => ['class' => 'form-control', 'placeholder' => 'Enter your book title'],
                'required' => false,
            ])
            ->add('disponibiliteLiv', ChoiceType::class, [
                'label' => 'Disponibilite',
                'placeholder' => 'Add a disponibility',
                'choices' => [
                    'Available' => 'DISPO',
                    'Not Available' => 'NON_DISPO',
                ],
                'attr' => ['class' => 'form-control'],
                'required' => false,
            ])
            ->add('categorieLiv', ChoiceType::class, [
                'label' => 'Categorie',
                'placeholder' => 'Add a category',
                'choices' => [
                    'Fiction' => 'FICTION',
                    'Mystery' => 'MYSTERE',
                ],
                'attr' => ['class' => 'form-control'],
                'required' => false,
            ])
            ->add('prixLiv', TextType::class, [
                'label' => 'Prix',
                'attr' => ['class' => 'form-control', 'placeholder' => 'Enter the book price'],
                'required' => false,
                'constraints' => [
                    new Assert\PositiveOrZero(message: "Le prix doit être un nombre positif ou zéro"),
                ],
            ])
            ->add('imagePath', FileType::class, [
                'label' => 'Book Image (PNG or JPEG file)',
                'mapped' => false,
                'required' => false,
            ])
            ->add('pdfPath', FileType::class, [
                'label' => 'Book PDF',
                'mapped' => false,
                'required' => false,
            ]);

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Books::class,
        ]);
    }
}
