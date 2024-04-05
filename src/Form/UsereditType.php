<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Constraints\File as AssertFile;
use Symfony\Component\Form\Extension\Core\Type\DateType;



class UsereditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
           
           
        ->add('nom')
        ->add('prenom')
        ->add('datenes', DateType::class, [
            'widget' => 'single_text',
            'format' => 'yyyy-MM-dd',
        ])
        ->add('mail')
            ->add('actif', ChoiceType::class, [
                "choices" => [
                    "actif" => 0,
                    "inactif" => 1,
                ],
            ])
                ->add('role', ChoiceType::class, [
                    "choices" => [
                    "admin" => 2,
                        "prof" => 1,
                        "etudent" => 0,
                    ],
                ])
                ->add('Edit', SubmitType::class, [
                    'label' => 'Register',
                    'attr' => [
                        'class' => 'form-submit form-button'
                    ]
                ]);
          
           ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
