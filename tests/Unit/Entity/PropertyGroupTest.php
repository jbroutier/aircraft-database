<?php

declare(strict_types=1);

namespace Tests\Unit\Entity;

use App\Entity\Property;
use App\Entity\PropertyGroup;
use PHPUnit\Framework\TestCase;

final class PropertyGroupTest extends TestCase
{
    /**
     * @testdox Method getProperties() returns an empty collection by default.
     */
    public function testGetProperties(): void
    {
        $propertyGroup = new PropertyGroup();

        self::assertEmpty($propertyGroup->getProperties());
    }

    /**
     * @testdox Method addProperty() adds a property.
     */
    public function testAddProperty(): void
    {
        $propertyGroup = new PropertyGroup();

        $property = \Mockery::mock(Property::class);
        $property
            ->expects('setPropertyGroup')
            ->with($propertyGroup)
            ->andReturnSelf();

        $propertyGroup->addProperty($property);

        self::assertEquals($property, $propertyGroup->getProperties()->first());
    }

    /**
     * @testdox Method removeProperty() removes a property.
     */
    public function testRemoveProperty(): void
    {
        $property = \Mockery::mock(Property::class);

        $propertyGroup = new PropertyGroup();
        $propertyGroup->setProperties([$property]);

        $property
            ->expects('getPropertyGroup')
            ->andReturn($propertyGroup);

        $property
            ->expects('setPropertyGroup')
            ->with(null)
            ->andReturnSelf();

        $propertyGroup->removeProperty($property);

        self::assertEmpty($propertyGroup->getProperties());
    }

    /**
     * @testdox Method setProperties() sets the properties.
     */
    public function testSetProperties(): void
    {
        $properties = [
            \Mockery::mock(Property::class),
            \Mockery::mock(Property::class),
        ];

        $propertyGroup = new PropertyGroup();
        $propertyGroup->setProperties($properties);

        self::assertEquals($properties, $propertyGroup->getProperties()->toArray());
    }
}
