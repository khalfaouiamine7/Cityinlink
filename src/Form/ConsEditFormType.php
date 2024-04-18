<?php

namespace App\Form;

use App\Entity\Consultaion;
use App\Entity\Specialite;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
class ConsEditFormType extends AbstractType
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
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
        ->add('adresse', null, [
            'label' => false,
            'attr' => [
                'class' => 'form-control',
            ],
        ])
        ->add('date', DateType::class, [
            'label' => false,
            'html5' => true,
            'widget' => 'single_text',
            'attr' => [
                'class' => 'form-control',
                'id' => 'html5-date-input'
            ],
        ])
        ->add('heure', TimeType::class, [
            'label' => false,
            'html5' => true,
            'widget' => 'single_text',
            'attr' => [
                'class' => 'form-control',
                'id' => 'html5-time-input'
            ],
        ])
        ->add('specialite', ChoiceType::class, [
            'attr' => [
                'class' => 'form-select',
            ],
            'choices' => $this->getSpecialiteChoices(),
            'expanded' => false,
            'multiple' => false,
            'label' => false,
        ]);
    }
    private function getSpecialiteChoices()
    {
        $specialites = $this->entityManager->getRepository(Specialite::class)->findAll();

        $choices = [];
        foreach ($specialites as $specialite) {
            $choices[$specialite->getNom()] = $specialite->getId();
        }

        return $choices;
    }
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Consultaion::class,
        ]);
    }
}
