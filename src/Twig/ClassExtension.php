<?php

declare(strict_types=1);

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigTest;

class ClassExtension extends AbstractExtension
{
    public function getTests(): array
    {
        return [
            new TwigTest('instanceOf', [$this, 'instanceOf']),
        ];
    }

    public function instanceOf(mixed $variable, string $className): bool
    {
        return $variable instanceof $className;
    }
}
