<?php

namespace App\Form;

use App\Entity\Quiz;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class QuizType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre', TextType::class, [
                'label' => 'Title',
                'required' => true,
            ])
            ->add('decrp', TextType::class, [
                'label' => 'Description',
                'required' => false,
            ])
            ->add('nbQuest', IntegerType::class, [
                'label' => 'Number of Questions',
                'required' => false,
            ])
            ->add('categorie', TextType::class, [
                'label' => 'Category',
                'required' => false,
            ])
            
            ->add('imageUrl', FileType::class, [
                'label' => 'Image',
                'required' => false,
                'attr' => [
                    'accept' => 'image/*', // Restrict to image files
                ],
                'data_class' => null, // Set data_class to null to handle file uploads
            ])
            
            ->add('userId', HiddenType::class, [
                'mapped' => false, // Set mapped to false for non-entity fields
                'data' => $options['user_id'], // Set the default value to the user ID
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Quiz::class,
            'user_id' => null, // Default value for user ID
        ]);
    }
}
