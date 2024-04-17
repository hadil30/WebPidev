<?php

// QuestiontType.php
namespace App\Form;

use App\Entity\Questiont;
use App\Entity\Reponse;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use App\Form\ReponseType;

class QuestiontType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('text', TextType::class, [
                'label' => false,
                'attr' => ['class' => 'form-control', 'placeholder' => 'Enter a question'],               'required' => true,
            ])

            ->add('reponses', CollectionType::class, [
                'entry_type' => ReponseType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'prototype' => true,
                'required' => true,
                'prototype_name' => '__reponse_prototype__',
                'error_bubbling' => false,
                'by_reference' => false,
                'attr' => [
                    'class' => 'reponse-container',
                ],
                'label' => false,

            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Questiont::class,
        ]);
    }
}
