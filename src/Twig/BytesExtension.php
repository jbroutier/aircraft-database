<?php

declare(strict_types=1);

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class BytesExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            new TwigFilter('format_bytes', [$this, 'formatBytes']),
        ];
    }

    public function formatBytes(int $bytes, int $decimals = 2): string
    {
        $units = ['o', 'Ko', 'Mo', 'Go', 'To', 'Po', 'Eo', 'Zo', 'Yo'];

        $pow = floor(log($bytes) / log(1024));
        $unit = $units[intval($pow)];
        $value = $bytes / pow(1024, $pow);

        return sprintf('%.' . $decimals . 'f %s', $value, $unit);
    }
}
