<?php

declare(strict_types=1);

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class PropertyOrderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', OrderChoiceType::class, ['required' => false])
            ->add('propertyGroup', OrderChoiceType::class, ['required' => false])
            ->add('type', OrderChoiceType::class, ['required' => false]);
    }
}
