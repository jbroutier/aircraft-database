<?php

declare(strict_types=1);

namespace App\Enum;

enum EngineFamily: string
{
    case Electric = 'electric';
    case None = 'none';
    case Piston = 'piston';
    case Propfan = 'propfan';
    case Ramjet = 'ramjet';
    case Turbofan = 'turbofan';
    case Turbojet = 'turbojet';
    case Turboprop = 'turboprop';
    case Turboshaft = 'turboshaft';

    public function label(): string
    {
        return match ($this) {
            self::Electric => 'Electric',
            self::None => 'None',
            self::Piston => 'Piston',
            self::Propfan => 'Propfan',
            self::Ramjet => 'Ramjet',
            self::Turbofan => 'Turbofan',
            self::Turbojet => 'Turbojet',
            self::Turboprop => 'Turboprop',
            self::Turboshaft => 'Turboshaft',
        };
    }
}
