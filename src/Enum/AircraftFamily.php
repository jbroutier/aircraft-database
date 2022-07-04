<?php

declare(strict_types=1);

namespace App\Enum;

enum AircraftFamily: string
{
    case Airplane = 'airplane';
    case Airship = 'airship';
    case Autogyro = 'autogyro';
    case Balloon = 'balloon';
    case Glider = 'glider';
    case Helicopter = 'helicopter';
    case Seaplane = 'seaplane';
    case Tiltrotor = 'tiltrotor';

    public function label(): string
    {
        return match ($this) {
            self::Airplane => 'Airplane',
            self::Airship => 'Airship',
            self::Autogyro => 'Autogyro',
            self::Balloon => 'Balloon',
            self::Glider => 'Glider',
            self::Helicopter => 'Helicopter',
            self::Seaplane => 'Seaplane',
            self::Tiltrotor => 'Tiltrotor',
        };
    }
}
