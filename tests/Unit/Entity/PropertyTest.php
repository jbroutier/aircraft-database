<?php

declare(strict_types=1);

namespace Tests\Unit\Entity;

use App\Entity\Property;
use App\Entity\PropertyGroup;
use App\Entity\PropertyValue;
use App\Enum\PropertyType;
use App\Enum\PropertyUnit;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PHPUnit\Framework\TestCase;

final class PropertyTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    /**
     * @testdox Method getPropertyGroup() returns null by default.
     */
    public function testGetPropertyGroup(): void
    {
        self::assertNull((new Property())->getPropertyGroup());
    }

    /**
     * @testdox Method setPropertyGroup() sets the property group.
     */
    public function testSetPropertyGroup(): void
    {
        $propertyGroup = \Mockery::mock(PropertyGroup::class);

        $property = (new Property())
            ->setPropertyGroup($propertyGroup);

        self::assertEquals($propertyGroup, $property->getPropertyGroup());
    }

    /**
     * @testdox Method getPropertyValues() returns an empty collection by default.
     */
    public function testGetPropertyValues(): void
    {
        self::assertEmpty((new Property())->getPropertyValues());
    }

    /**
     * @testdox Method addPropertyValue() adds a property value.
     */
    public function testAddPropertyValue(): void
    {
        $property = new Property();

        $propertyValue = \Mockery::mock(PropertyValue::class);
        $propertyValue
            ->expects('setProperty')
            ->once()
            ->with($property)
            ->andReturnSelf();

        $property->addPropertyValue($propertyValue);

        self::assertEquals($propertyValue, $property->getPropertyValues()->first());
    }

    /**
     * @testdox Method removePropertyValue() removes a property value.
     */
    public function testRemovePropertyValue(): void
    {
        $propertyValue = \Mockery::mock(PropertyValue::class);

        $property = (new Property())
            ->setPropertyValues([$propertyValue]);

        $propertyValue
            ->expects('getProperty')
            ->once()
            ->andReturn($property);

        $propertyValue
            ->expects('setProperty')
            ->once()
            ->with(null)
            ->andReturnSelf();

        $property->removePropertyValue($propertyValue);

        self::assertEmpty($property->getPropertyValues());
    }

    /**
     * @testdox Method setPropertyValues() sets the property values.
     */
    public function testSetPropertyValues(): void
    {
        $propertyValues = [
            \Mockery::mock(PropertyValue::class),
            \Mockery::mock(PropertyValue::class),
        ];

        $property = (new Property())
            ->setPropertyValues($propertyValues);

        self::assertEquals($propertyValues, $property->getPropertyValues()->toArray());
    }

    /**
     * @testdox Method getType() returns null by default.
     */
    public function testGetType(): void
    {
        self::assertNull((new Property())->getType());
    }

    /**
     * @testdox Method setType() sets the type.
     */
    public function testSetType(): void
    {
        $property = (new Property())
            ->setType(PropertyType::Boolean);

        self::assertEquals(PropertyType::Boolean, $property->getType());
    }

    /**
     * @testdox Method getUnit() returns null by default.
     */
    public function testGetUnit(): void
    {
        self::assertNull((new Property())->getUnit());
    }

    /**
     * @testdox Method setUnit() sets the unit.
     */
    public function testSetUnit(): void
    {
        $property = (new Property())
            ->setUnit(PropertyUnit::CelsiusDegree);

        self::assertEquals(PropertyUnit::CelsiusDegree, $property->getUnit());
    }
}
