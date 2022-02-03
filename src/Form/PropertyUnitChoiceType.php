<?php

declare(strict_types=1);

namespace App\Form;

use App\Enum\PropertyUnit;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PropertyUnitChoiceType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'choice_label' => fn(PropertyUnit $choice) => $choice->label(),
            'class' => PropertyUnit::class,
        ]);
    }

    public function getParent(): string
    {
        return EnumType::class;
    }
}
