<?php

declare(strict_types=1);

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrderChoiceType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $choices = [
            'Ascending' => 'asc',
            'Descending' => 'desc',
        ];

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
