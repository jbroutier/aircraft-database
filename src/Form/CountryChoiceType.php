<?php

declare(strict_types=1);

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CountryChoiceType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'choice_label' => function ($choice, $key, $value) {
                return '<span class="fp ' . strtolower($value) . ' me-2" aria-hidden="true"></span> ' . $key;
            }
        ]);
    }

    public function getParent(): string
    {
        return CountryType::class;
    }
}
