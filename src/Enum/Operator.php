<?php

declare(strict_types=1);

namespace App\Enum;

enum Operator: string
{
    case Equal = 'eq';
    case NotEqual = 'neq';
    case GreaterThan = 'gt';
    case GreaterThanOrEqual = 'gte';
    case LessThan = 'lt';
    case LessThanOrEqual = 'lte';

    public function label(): string
    {
        return match ($this) {
            Operator::Equal => 'Equal',
            Operator::NotEqual => 'Not equal',
            Operator::GreaterThan => 'Greater than',
            Operator::GreaterThanOrEqual => 'Greater than or equal',
            Operator::LessThan => 'Less than',
            Operator::LessThanOrEqual => 'Less than or equal',
        };
    }
}
