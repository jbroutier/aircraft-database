<?php

declare(strict_types=1);

namespace App\Enum;

enum PropertyType: string
{
    case Boolean = 'boolean';
    case Date = 'date';
    case Float = 'float';
    case Integer = 'integer';
    case String = 'string';
    case Url = 'url';

    public function label(): string
    {
        return match ($this) {
            self::Boolean => 'Boolean',
            self::Date => 'Date',
            self::Float => 'Float',
            self::Integer => 'Integer',
            self::String => 'String',
            self::Url => 'Url',
        };
    }
}
