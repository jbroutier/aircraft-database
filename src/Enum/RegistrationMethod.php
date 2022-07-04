<?php

declare(strict_types=1);

namespace App\Enum;

enum RegistrationMethod: string
{
    case CommandLine = 'command-line';
    case Google = 'google';
    case RegistrationForm = 'registration-form';

    public function label(): string
    {
        return match ($this) {
            self::CommandLine => 'Command line',
            self::Google => 'Google',
            self::RegistrationForm => 'Registration form',
        };
    }
}
