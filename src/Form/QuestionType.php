<?php


namespace App\Form;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

use App\Entity\Question;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class QuestionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('quest')
            ->add('rep1')
            ->add('rep2')
            ->add('rep3')
            ->add('rep4'); // Use 'hidden' class for quiz ID
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Question::class,
        ]);
    }
}

