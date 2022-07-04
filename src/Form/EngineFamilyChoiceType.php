<?php

declare(strict_types=1);

namespace App\Form;

use App\Enum\EngineFamily;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EngineFamilyChoiceType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'choice_label' => fn(EngineFamily $choice) => $choice->label(),
            'class' => EngineFamily::class,
        ]);
    }

    public function getParent(): string
    {
        return EnumType::class;
    }
}
