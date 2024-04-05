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
use Symfony\Component\Form\Extension\Core\Type\PasswordType;


class UsereditprofilType extends AbstractType
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
            ->add('password', PasswordType::class, [
                'label' => 'Mot de passe',
                'attr' => [
                    'placeholder' => '*****************'
                ]
            ])
                ->add('image', FileType::class, [
                    'label' => 'Preuve visuelle',
                    'mapped' => false,
                    'required' => false,
                    'constraints' => [
                        new AssertFile([
                            'maxSize' => '1024k',
                            'mimeTypes' => [
                                'image/jpeg',
                                'image/png',
                                'image/gif',
                            ],
                            'mimeTypesMessage' => 'Please upload a valid image file (JPG, JPEG, PNG or GIF)',
                        ])
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
