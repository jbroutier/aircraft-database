<?php

declare(strict_types=1);

namespace App\Enum;

enum PropertyUnit: string
{
    case CelsiusDegree = 'celsius-degree';
    case Centimetre = 'centimetre';
    case CubicCentimetre = 'cubic-centimetre';
    case CubicMetre = 'cubic-metre';
    case DecanewtonMetre = 'decanewton-metre';
    case FahrenheitDegree = 'fahrenheit-degree';
    case Foot = 'foot';
    case Horsepower = 'horsepower';
    case Kilogram = 'kilogram';
    case Kilonewton = 'kilonewton';
    case Kilowatt = 'kilowatt';
    case Knot = 'knot';
    case Litre = 'litre';
    case Metre = 'metre';
    case Millimetre = 'millimetre';
    case NauticalMile = 'nautical-mile';
    case SquareCentimetre = 'square-centimetre';
    case SquareMetre = 'square-metre';

    public function label(): string
    {
        return match ($this) {
            self::CelsiusDegree => '°C',
            self::Centimetre => 'cm',
            self::CubicCentimetre => 'cm³',
            self::CubicMetre => 'm³',
            self::DecanewtonMetre => 'daN/m',
            self::FahrenheitDegree => '°F',
            self::Foot => 'ft',
            self::Horsepower => 'hp',
            self::Kilogram => 'kg',
            self::Kilonewton => 'kN',
            self::Kilowatt => 'kW',
            self::Knot => 'kt',
            self::Litre => 'l',
            self::Metre => 'm',
            self::Millimetre => 'mm',
            self::NauticalMile => 'nmi',
            self::SquareCentimetre => 'cm²',
            self::SquareMetre => 'm²',
        };
    }
}
