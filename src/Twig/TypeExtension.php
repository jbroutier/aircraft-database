<?php

declare(strict_types=1);

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class TypeExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            new TwigFilter('boolean', [$this, 'boolean']),
            new TwigFilter('float', [$this, 'float']),
            new TwigFilter('integer', [$this, 'integer']),
            new TwigFilter('string', [$this, 'string']),
        ];
    }

    public function boolean(string $value): ?bool
    {
        return filter_var(
            $value,
            FILTER_VALIDATE_BOOLEAN,
            [
                'flags' => FILTER_NULL_ON_FAILURE,
                'options' => [
                    'default' => null,
                ],
            ]
        );
    }

    public function float(string $value): ?float
    {
        return filter_var(
            $value,
            FILTER_VALIDATE_FLOAT,
            [
                'options' => [
                    'decimal' => '.',
                    'default' => null,
                ],
            ]
        );
    }

    public function integer(string $value): ?int
    {
        return filter_var(
            $value,
            FILTER_VALIDATE_INT,
            [
                'options' => [
                    'default' => null,
                ],
            ]
        );
    }

    public function string(string $value): ?string
    {
        return filter_var(
            $value,
            FILTER_VALIDATE_REGEXP,
            [
                'options' => [
                    'default' => null,
                    'regexp' => '/^[\w\s]+$/i',
                ],
            ]
        );
    }
}
