<?php

declare(strict_types=1);

namespace App\Twig\Extension;

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

    public function formatBytes(float $bytes, int $decimals = 2): string
    {
        $units = ['b', 'Kb', 'Mb', 'Gb', 'Tb', 'Pb', 'Eb', 'Zb', 'Yb'];

        $pow = floor(log($bytes) / log(1024));
        $unit = $units[intval($pow)];
        $value = $bytes / pow(1024, $pow);

        return sprintf('%.' . $decimals . 'f %s', $value, $unit);
    }
}
