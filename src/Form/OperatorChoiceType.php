<?php

declare(strict_types=1);

namespace App\Form;

use App\Enum\Operator;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OperatorChoiceType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'choice_label' => fn(Operator $choice) => $choice->label(),
            'class' => Operator::class,
        ]);
    }

    public function getParent(): string
    {
        return EnumType::class;
    }
}
