<?php

declare(strict_types=1);

namespace App\Form;

use App\Enum\AircraftFamily;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AircraftFamilyChoiceType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'choice_label' => fn(AircraftFamily $choice) => $choice->label(),
            'class' => AircraftFamily::class,
        ]);
    }

    public function getParent(): string
    {
        return EnumType::class;
    }
}
