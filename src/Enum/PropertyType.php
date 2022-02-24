<?php

declare(strict_types=1);

namespace App\Enum;

enum PropertyType: string
{
    case Boolean = 'boolean';
    case Float = 'float';
    case Integer = 'integer';
    case String = 'string';
    case Url = 'url';

    public function label(): string
    {
        return match ($this) {
            PropertyType::Boolean => 'Boolean',
            PropertyType::Float => 'Float',
            PropertyType::Integer => 'Integer',
            PropertyType::String => 'String',
            PropertyType::Url => 'Url',
        };
    }
}
