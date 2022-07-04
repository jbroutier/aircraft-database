<?php

declare(strict_types=1);

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PropertyTypeFilterType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_extraction_method' => 'default',
        ]);
    }

    public function getBlockPrefix(): string
    {
        return 'filter_property_type';
    }

    public function getParent(): string
    {
        return PropertyTypeChoiceType::class;
    }
}
