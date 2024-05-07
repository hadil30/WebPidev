<?php

namespace App\Form;

use App\Entity\Reponse;
use App\Form\ReponseArrayToStringTransformer as FormReponseArrayToStringTransformer;
use App\Form\Type\ReponseArrayToStringTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReponseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('isCorrect', CheckboxType::class, [
                'label' => false, // Prevents label from being auto-generated
                'required' => false,
                'attr' => ['class' => 'inline-checkbox'], // Add class to checkbox


            ])
            ->add('reponse', TextType::class, [
                'label' => false, // Prevents label from being auto-generated
                'required' => false,
                'attr' => ['class' => 'inline-checkbox'], // Add class to checkbox

            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Reponse::class,
        ]);
    }
}
