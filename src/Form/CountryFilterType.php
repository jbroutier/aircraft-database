<?php

declare(strict_types=1);

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CountryFilterType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_extraction_method' => 'default',
        ]);
    }

    public function getBlockPrefix(): string
    {
        return 'filter_country';
    }

    public function getParent(): string
    {
        return CountryChoiceType::class;
    }
}
