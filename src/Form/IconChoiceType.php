<?php

declare(strict_types=1);

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class IconChoiceType extends AbstractType
{
    public function __construct(protected string $projectDir)
    {
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $filename = $this->projectDir . '/res/icons.json';

        if (($json = file_get_contents($filename)) === false) {
            throw new \RuntimeException('Could not read file "' . $filename . '".');
        }

        $resolver->setDefaults([
            'choices' => json_decode($json, true),
            'choice_label' => function ($choice, $key, $value) {
                return '<span class="far fa-' . $value . ' fa-fw me-2" aria-hidden="true"></span> ' . $value;
            },
            'data_class' => null,
        ]);
    }

    public function getParent(): string
    {
        return ChoiceType::class;
    }
}
