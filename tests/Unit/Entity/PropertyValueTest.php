<?php

declare(strict_types=1);

namespace Tests\Unit\Entity;

use App\Entity\Property;
use App\Entity\PropertyValue;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PHPUnit\Framework\TestCase;

final class PropertyValueTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    /**
     * @testdox Method getProperty() returns null by default.
     */
    public function testGetProperty(): void
    {
        $propertyValue = new PropertyValue();

        self::assertNull($propertyValue->getProperty());
    }

    /**
     * @testdox Method setProperty() sets the property.
     */
    public function testSetProperty(): void
    {
        $property = \Mockery::mock(Property::class);

        $propertyValue = new PropertyValue();
        $propertyValue->setProperty($property);

        self::assertEquals($property, $propertyValue->getProperty());
    }

    /**
     * @testdox Method getValue() returns null by default.
     */
    public function testGetValue(): void
    {
        $propertyValue = new PropertyValue();

        self::assertNull($propertyValue->getValue());
    }

    /**
     * @testdox Method setValue() sets the value.
     */
    public function testSetValue(): void
    {
        $propertyValue = new PropertyValue();
        $propertyValue->setValue('42');

        self::assertEquals('42', $propertyValue->getValue());
    }
}
