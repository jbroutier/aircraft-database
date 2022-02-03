<?php

declare(strict_types=1);

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ManufacturerOrderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('country', OrderChoiceType::class, ['required' => false])
            ->add('name', OrderChoiceType::class, ['required' => false]);
    }
}
