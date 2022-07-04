<?php

declare(strict_types=1);

namespace Tests\Unit\Entity\Traits;

use App\Entity\Interface\PropertiesAwareInterface;
use App\Entity\Property;
use App\Entity\PropertyGroup;
use App\Entity\PropertyValue;
use App\Entity\Traits\PropertiesAwareTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PHPUnit\Framework\TestCase;

final class PropertiesAwareEntity implements PropertiesAwareInterface
{
    use PropertiesAwareTrait;

    public function __construct()
    {
        $this->propertyValues = new ArrayCollection();
    }
}

final class PropertiesAwareTraitTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    /**
     * @testdox Method getProperties() returns the properties.
     */
    public function testGetProperties(): void
    {
        $property = \Mockery::mock(Property::class);

        $propertyValue = \Mockery::mock(PropertyValue::class);
        $propertyValue
            ->expects('getProperty')
            ->twice()
            ->andReturn($property);

        $entity = (new PropertiesAwareEntity())
            ->addPropertyValue($propertyValue);

        self::assertCount(1, $entity->getProperties());
        self::assertContains($property, $entity->getProperties());
    }

    /**
     * @testdox Method getPropertyGroups() returns the property groups.
     */
    public function testGetPropertyGroups(): void
    {
        $propertyGroup = \Mockery::mock(PropertyGroup::class);

        $propertyValue = \Mockery::mock(PropertyValue::class);
        $propertyValue
            ->expects('getPropertyGroup')
            ->twice()
            ->andReturn($propertyGroup);

        $entity = (new PropertiesAwareEntity())
            ->addPropertyValue($propertyValue);

        self::assertCount(1, $entity->getPropertyGroups());
        self::assertContains($propertyGroup, $entity->getPropertyGroups());
    }

    /**
     * @testdox Method addPropertyValue() adds a property value.
     */
    public function testAddPropertyValue(): void
    {
        $propertyValue = \Mockery::mock(PropertyValue::class);

        $entity = (new PropertiesAwareEntity())
            ->addPropertyValue($propertyValue);

        self::assertCount(1, $entity->getPropertyValues());
        self::assertContains($propertyValue, $entity->getPropertyValues());
    }

    /**
     * @testdox Method removePropertyValue() removes a property value.
     */
    public function testRemovePropertyValue(): void
    {
        $propertyValue = \Mockery::mock(PropertyValue::class);

        $entity = new PropertiesAwareEntity();
        $entity
            ->setPropertyValues([$propertyValue])
            ->removePropertyValue($propertyValue);

        self::assertEmpty($entity->getPropertyValues());
    }

    /**
     * @testdox Method setPropertyValues() sets the property values.
     */
    public function testSetPropertyValues(): void
    {
        $propertyValue = \Mockery::mock(PropertyValue::class);

        $entity = (new PropertiesAwareEntity())
            ->setPropertyValues([$propertyValue]);

        self::assertCount(1, $entity->getPropertyValues());
        self::assertContains($propertyValue, $entity->getPropertyValues());
    }
}
