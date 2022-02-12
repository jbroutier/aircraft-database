<?php

declare(strict_types=1);

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class AircraftModelFiltersType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('aircraftType', AircraftTypeChoiceType::class, ['required' => false])
            ->add('manufacturer', ManufacturerChoiceType::class, ['required' => false])
            ->add('name', TextType::class, ['required' => false])
            ->add('propertyValues', FilterCollectionType::class)
            ->add('tags', TagChoiceType::class, ['multiple' => true, 'required' => false]);
    }
}
