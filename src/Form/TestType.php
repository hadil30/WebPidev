<?php

use App\Entity\Test;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\AbstractType;
use App\Form\QuestiontType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class TestType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, [
                'attr' => ['class' => 'form-control', 'placeholder' => 'Enter a name'],
                // No need to set the placeholder here if it's using the current value
            ])
            ->add('description', TextType::class, ['attr' => ['class' => 'form-control', 'placeholder' => 'Enter a description'],])
            ->add('categorie', ChoiceType::class, [
                'choices' => [
                    'Language' => 'Language',
                    'Academic' => 'Academic',
                    'University' => 'University',
                    'Skills' => 'Skills',
                    'Citizenship' => 'Citizenship',
                    'Knowledge' => 'Knowledge',
                    'IQ' => 'IQ',
                ],
                'placeholder' => 'Choose a category',

            ]);
        $builder->add('questions', CollectionType::class, [
            'entry_type' => QuestiontType::class,
            'entry_options' => ['label' => false], // Ensure entry options are correct
            'allow_add' => true,
            'allow_delete' => true,
            'by_reference' => false,
            'prototype' => true,
            'attr' => ['class' => 'form-control', 'placeholder' => 'Enter a description'],
            'attr' => ['class' => 'question-container'],
            'error_bubbling' => false, // Prevent errors from bubbling up to the parent form
            'by_reference' => false,
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Test::class,
        ]);
    }
}
