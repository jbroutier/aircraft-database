<?php

declare(strict_types=1);

namespace App\Twig\Extension;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class TypeExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            new TwigFilter('boolean', [$this, 'boolean']),
            new TwigFilter('date', [$this, 'date']),
            new TwigFilter('float', [$this, 'float']),
            new TwigFilter('integer', [$this, 'integer']),
            new TwigFilter('string', [$this, 'string']),
            new TwigFilter('url', [$this, 'url']),
        ];
    }

    public function boolean(string $value): ?bool
    {
        return filter_var($value, FILTER_VALIDATE_BOOLEAN, [
            'flags' => FILTER_NULL_ON_FAILURE,
        ]);
    }

    public function date(string $value): ?\DateTime
    {
        if (($dateTime = \DateTime::createFromFormat('Y-m-d', $value)) === false) {
            return null;
        }

        if (($lastErrors = \DateTime::getLastErrors()) !== false && $lastErrors['warning_count'] !== 0) {
            return null;
        }

        return $dateTime;
    }

    public function float(string $value): ?float
    {
        return filter_var($value, FILTER_VALIDATE_FLOAT, [
            'flags' => FILTER_NULL_ON_FAILURE,
        ]);
    }

    public function integer(string $value): ?int
    {
        return filter_var($value, FILTER_VALIDATE_INT, [
            'flags' => FILTER_NULL_ON_FAILURE,
        ]);
    }

    public function string(string $value): ?string
    {
        return filter_var($value, FILTER_VALIDATE_REGEXP, [
            'flags' => FILTER_NULL_ON_FAILURE,
            'options' => ['regexp' => '/^(?![\t\s])(.+)$/i'],
        ]);
    }

    public function url(string $value): ?string
    {
        return filter_var($value, FILTER_VALIDATE_URL, [
            'flags' => FILTER_NULL_ON_FAILURE,
        ]);
    }
}
