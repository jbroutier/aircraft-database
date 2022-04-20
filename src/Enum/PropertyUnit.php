<?php

declare(strict_types=1);

namespace App\Enum;

enum PropertyUnit: string
{
    case CelsiusDegrees = '°C';
    case Centimetres = 'cm';
    case CubicMetres = 'm³';
    case DecaNewtonsMetres = 'daNm';
    case FahrenheitDegrees = '°F';
    case Feet = 'ft';
    case Horsepower = 'hp';
    case Kilograms = 'kg';
    case Kilonewtons = 'kN';
    case Kilowatts = 'kW';
    case Knots = 'Kt';
    case Litres = 'l';
    case Metres = 'm';
    case NauticalMiles = 'nm';
    case SquareMetres = 'm²';

    public function label(): string
    {
        return $this->value;
    }
}
