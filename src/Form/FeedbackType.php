<?php

// FeedbackType.php
namespace App\Form;

use App\Entity\Feedback;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class FeedbackType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('text', TextType::class, [
                'label' => false, // Set label to false to hide the label
                'attr' => [
                    'class' => 'form-control', // Add a class for styling
                    'placeholder' => 'Enter feedback', // Add a placeholder for user guidance
                ],
            ]);
    }

}