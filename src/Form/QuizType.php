<?php

namespace App\Form;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

use App\Entity\Quiz;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class QuizType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre', TextType::class, [
                'label' => 'Title',
                'constraints' => [
                    new Assert\NotBlank(),
                ],
            ])
            ->add('decrp', TextType::class, [
                'label' => 'Description',
                'constraints' => [
                    new Assert\NotBlank(),
                ],
            ])
            ->add('nbQuest', IntegerType::class, [
                'label' => 'Number of Questions',
                'constraints' => [
                    new Assert\NotBlank(),
                ],
            ])
            ->add('categorie', ChoiceType::class, [
                'label' => 'Category',
                'choices' => [
                    'Maths' => 'maths',
                    'Physics' => 'physics',
                    'Entertainment' => 'entertainment',
                ],
                'placeholder' => 'Choose an option', // Optional placeholder text
                'constraints' => [
                    new Assert\NotBlank(),
                ],
            ])
            ->add('imageUrl', FileType::class, [
                'label' => 'Image',
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\File([
                        'maxSize' => '5M',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                            // Add more allowed image MIME types if needed
                        ],
                        'mimeTypesMessage' => 'Please upload a valid image file (JPEG, PNG).',
                    ]),
                ],
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
