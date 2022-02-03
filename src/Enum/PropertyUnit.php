<?php

declare(strict_types=1);

namespace App\Enum;

enum PropertyUnit: string
{
    case CelsiusDegrees = '°C';
    case Centimetres = 'cm';
    case CubicMetres = 'm³';
    case FahrenheitDegrees = '°F';
    case Feet = 'ft';
    case Kilograms = 'kg';
    case Kilonewtons = 'kN';
    case Litres = 'l';
    case Metres = 'm';
    case NauticalMiles = 'nm';
    case SquareMetres = 'm²';

    public function label(): string
    {
        return $this->value;
    }
}
