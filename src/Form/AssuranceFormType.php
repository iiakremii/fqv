<?php

namespace App\Form;

use App\Entity\Assurance;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class AssuranceFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('type', ChoiceType::class, [
                'choices' => [
                    'AssuranceAuto' => 'AssuranceAuto',
                    'AssuranceVie' => 'AssuranceVie',
                    'AssuranceVoyage' => 'AssuranceVoyage',
                ],
            ])
            ->add('montant')
            ->add('date_debut')
            ->add('date_fin')
            ->add('contrat')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Assurance::class,
        ]);
    }
}
