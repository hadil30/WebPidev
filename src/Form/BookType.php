<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\Books;

class BookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nomLiv')
            ->add('disponibiliteLiv', ChoiceType::class, [
                'choices' => [
                    'Available' => 'DISPO',
                    'Not Available' => 'NON_DISPO',
                ],
            ])
            ->add('categorieLiv', ChoiceType::class, [
                'choices' => [
                    'Fiction' => 'FICTION',
                    'Mystery' => 'MYSTERE',
                ],
            ])
            ->add('prixLiv')
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
