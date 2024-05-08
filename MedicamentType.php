<?php

namespace App\Form;

use App\Entity\Medicament;
use App\Entity\Pharmacie;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;


class MedicamentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a name for the medicament.',
                    ]),
                    new Length([
                        'min' => 3,
                        'max' => 100,
                        'minMessage' => 'The name must be at least {{ limit }} characters long.',
                        'maxMessage' => 'The name cannot be longer than {{ limit }} characters.',
                    ]),
                ],
            ])
            ->add('description', TextType::class, [
                // Optionally add constraints here if needed
            ])
            ->add('prix', NumberType::class, [ ])
            ->add('type', TextType::class, [
                // Optionally add constraints here if needed
            ])
            ->add('type', ChoiceType::class, [
                'choices' => [
                    'Paracetamol' => 'paracetamol',
                    'Antibiotique' => 'antibiotique',
                    'Anti-inflammatoire' => 'anti-inflammatoire',
                ],
            ])
            ->add('idPharmacie', EntityType::class, [
                'class' => Pharmacie::class,
                'choice_label' => 'nom',  // Assuming 'nom' is a property of Pharmacie that you want to display
                'constraints' => [
                    new NotNull([
                        'message' => 'Please select a pharmacy.',
                    ])
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Medicament::class,
            'validation_groups' => ['Default', 'creation'],
        ]);
    }
}
