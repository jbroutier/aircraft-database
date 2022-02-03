<?php

declare(strict_types=1);

namespace App\Form;

use Composer\Spdx\SpdxLicenses;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LicenseChoiceType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $licenses = new SpdxLicenses();
        $choices = array_combine(
            array_column($licenses->getLicenses(), 1),
            array_keys($licenses->getLicenses())
        );

        $resolver->setDefaults([
            'choices' => $choices,
            'data_class' => null,
        ]);
    }

    public function getParent(): string
    {
        return ChoiceType::class;
    }
}
