<?php

declare(strict_types=1);

namespace Tests\Unit\Enum;

use App\Enum\PropertyUnit;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;

use function PHPUnit\Framework\assertEquals;

final class PropertyUnitTest
{
    use MockeryPHPUnitIntegration;

    /**
     * @testdox Method label() returns the enum value.
     */
    public function testLabel(): void
    {
        $propertyUnit = PropertyUnit::Metres;

        assertEquals($propertyUnit->value, $propertyUnit->label());
    }
}
