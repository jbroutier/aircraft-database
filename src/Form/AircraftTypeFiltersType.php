<?php

declare(strict_types=1);

namespace App\Form;

use Lexik\Bundle\FormFilterBundle\Filter\FilterOperands;
use Lexik\Bundle\FormFilterBundle\Filter\Form\Type\TextFilterType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AircraftTypeFiltersType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('aircraftFamily', AircraftFamilyFilterType::class, ['required' => false])
            ->add('engineFamily', EngineFamilyFilterType::class, ['required' => false])
            ->add('iataCode', TextFilterType::class, ['required' => false])
            ->add('icaoCode', TextFilterType::class, ['required' => false])
            ->add('manufacturer', ManufacturerFilterType::class, ['required' => false])
            ->add('name', TextFilterType::class, [
                'condition_pattern' => FilterOperands::STRING_CONTAINS,
                'required' => false,
            ])
            ->add('tags', TagFilterType::class, ['multiple' => true, 'required' => false]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'csrf_protection' => false,
            'validation_groups' => false,
        ]);
    }

    public function getBlockPrefix(): string
    {
        return 'filters';
    }
}
