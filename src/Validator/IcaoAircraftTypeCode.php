<?php

declare(strict_types=1);

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

#[\Attribute(\Attribute::TARGET_PROPERTY | \Attribute::TARGET_METHOD)]
class IcaoAircraftTypeCode extends Constraint
{
    public string $message = 'This value should be a valid ICAO aircraft type code.';
}
