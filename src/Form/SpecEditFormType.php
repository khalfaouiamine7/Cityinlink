<?php

namespace App\Form;

use App\Entity\Specialite;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class SpecEditFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('id', TextType::class, [
            'required' => false,
            'label' => false,
            'disabled' => true,
            'attr' => [
                'class' => 'form-control',
                'id' => 'uid',
            ],
        ])
        ->add('nom', null, [
            'label' => false,
            'attr' => [
                'class' => 'form-control',
            ],
        ])
        ->add('description', TextareaType::class, [
            'label' => false,
            'attr' => [
                'class' => 'form-control',
            ],
        ])
        ->add('type', null, [
            'label' => false,
            'attr' => [
                'class' => 'form-control',
            ],
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Specialite::class,
        ]);
    }
}
