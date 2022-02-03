<?php

declare(strict_types=1);

namespace App\Form;

use App\Enum\PropertyType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PropertyTypeChoiceType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'choice_label' => fn(PropertyType $choice) => $choice->label(),
            'class' => PropertyType::class,
        ]);
    }

    public function getParent(): string
    {
        return EnumType::class;
    }
}
