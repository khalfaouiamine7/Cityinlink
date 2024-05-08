<?php

declare(strict_types=1);

namespace App\Form;

use App\Entity\Pharmacie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\Range;

class PharmacieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'The name of the pharmacy cannot be blank.'
                    ]),
                    new Length([
                        'min' => 3,
                        'max' => 100,
                        'minMessage' => 'The name must be at least {{ limit }} characters long.',
                        'maxMessage' => 'The name cannot be longer than {{ limit }} characters.',
                    ]),
                ],
            ])
            ->add('adresse', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'The address cannot be blank.'
                    ]),
                    new Length([
                        'min' => 10,
                        'max' => 200,
                        'minMessage' => 'The address must be at least {{ limit }} characters long.',
                        'maxMessage' => 'The address cannot be longer than {{ limit }} characters.',
                    ]),
                ],
            ])
            ->add('contact', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'The contact information cannot be blank.'
                    ]),
                    new Length([
                        'min' => 5,
                        'max' => 50,
                        'minMessage' => 'The contact must be at least {{ limit }} characters long.',
                        'maxMessage' => 'The contact cannot be longer than {{ limit }} characters.',
                    ]),
                ],
            ])
            ->add('note', ChoiceType::class, [
                'choices' => [
                    '1 star' => 1,
                    '2 stars' => 2,
                    '3 stars' => 3,
                    '4 stars' => 4,
                    '5 stars' => 5,
                ],
                'placeholder' => 'Choose a rating',
                'constraints' => [
                    new NotNull([
                        'message' => 'Please provide a rating for the pharmacy.'
                    ]),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Pharmacie::class,
            'validation_groups' => ['Default', 'creation'],
        ]);
    }
}
