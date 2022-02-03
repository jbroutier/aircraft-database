<?php

declare(strict_types=1);

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class AircraftModelOrderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('aircraftType', OrderChoiceType::class, ['required' => false])
            ->add('manufacturer', OrderChoiceType::class, ['required' => false])
            ->add('name', OrderChoiceType::class, ['required' => false]);
    }
}
