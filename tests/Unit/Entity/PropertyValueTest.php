<?php

declare(strict_types=1);

namespace Tests\Unit\Entity;

use App\Entity\Property;
use App\Entity\PropertyGroup;
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
        self::assertNull((new PropertyValue())->getProperty());
    }

    /**
     * @testdox Method setProperty() sets the property.
     */
    public function testSetProperty(): void
    {
        $property = \Mockery::mock(Property::class);
        $propertyValue = (new PropertyValue())
            ->setProperty($property);

        self::assertEquals($property, $propertyValue->getProperty());
    }

    /**
     * @testdox Method getPropertyGroup() returns the property group.
     */
    public function testGetPropertyGroup(): void
    {
        $propertyGroup = \Mockery::mock(PropertyGroup::class);

        $property = \Mockery::mock(Property::class);
        $property
            ->expects('getPropertyGroup')
            ->once()
            ->andReturn($propertyGroup);

        $propertyValue = (new PropertyValue())
            ->setProperty($property);

        self::assertEquals($propertyGroup, $propertyValue->getPropertyGroup());
    }

    /**
     * @testdox Method getValue() returns null by default.
     */
    public function testGetValue(): void
    {
        self::assertNull((new PropertyValue())->getValue());
    }

    /**
     * @testdox Method setValue() sets the value.
     */
    public function testSetValue(): void
    {
        $propertyValue = (new PropertyValue())
            ->setValue('37.8541');

        self::assertEquals('37.8541', $propertyValue->getValue());
    }
}
