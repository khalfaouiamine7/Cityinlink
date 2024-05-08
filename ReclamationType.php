<?php



// src/Form/ReclamationType.php
namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReclamationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('pharmacyName', TextType::class, ['label' => 'Nom de la Pharmacie'])
            ->add('email', EmailType::class, ['label' => 'Votre Email'])
            ->add('description', TextareaType::class, ['label' => 'Description de la Réclamation']);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your default values or options here if needed
        ]);
    }
}
