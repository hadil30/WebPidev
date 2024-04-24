<?php

namespace App\Form;

use App\Entity\Cours;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class CoursType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre', TextType::class, [
                'label' => 'Titre',
                'attr' => ['class' => 'form-control', 'placeholder' => 'Entrez un titre'],
                'required' => false,
            ])
            ->add('description', TextType::class, [
                'label' => 'Description',
                'attr' => ['class' => 'form-control', 'placeholder' => 'Entrez une description'],
                'required' => false,
            ])
            ->add('niveau', ChoiceType::class, [
                'label' => 'Niveau',
                'placeholder' => 'Add a level',
                'choices' => [
                    'Beginner' => 'Beginner',
                    'Intermediate' => 'Intermediate',
                    'Advanced' => 'Advanced',
                ],
                'attr' => ['class' => 'form-control'],
                'required' => false,
            ])
            ->add('ImagePath', FileType::class, [
                'label' => 'Course Image (PNG or JPEG file)',
                'mapped' => false,
                'required' => false,
            ])
            ->add('link', UrlType::class, [
                'label' => 'Lien de la vidéo',
                'attr' => ['class' => 'form-control', 'placeholder' => 'Entrez le lien de la vidéo'],
                'required' => false,
                'constraints' => [
                    new Assert\Url(message: "Le lien de la vidéo doit être une URL valide"),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Cours::class,
        ]);
    }
}
