<?php

namespace App\Form;

use App\Entity\Specialite;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class SpecialiteFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
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
