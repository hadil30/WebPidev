<?php

use App\Entity\Events;
use App\Form\FeedbackType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\AbstractType;

use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class EventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, [
                'attr' => ['class' => 'form-control', 'placeholder' => 'Enter a name']
            ])
            ->add('DESCRIPTION', TextType::class)
            ->add('DATEe', DateType::class, [
                'widget' => 'single_text', // Renders a single input field for the date
                'html5' => false, // Set to false to render as a regular HTML input type="text"
                // You can add more options here as needed
            ])
            ->add('STATUS', ChoiceType::class, [
                'choices' => [
                    'ACTIF' => 'ACTIF',
                    'INACTIF' => 'INACTIF',
                    'PLANIFIER' => 'PLANIFIER',
                ],
                'placeholder' => 'Choose a Status',
            ])
            ->add('Typee', ChoiceType::class, [
                'choices' => [
                    'ATELIER' => 'ATELIER',
                    'FORMATION' => 'FORMATION',
                    'HACKATHON' => 'HACKATHON',
                ],
                'placeholder' => 'Choose a Type',
            ])
            ->add('imageUrl')
            ->add('user_id', TextType::class, [
                'attr' => ['class' => 'form-control', 'placeholder' => 'Enter a User ID']
            ]);
            
            
            
    }

    
}