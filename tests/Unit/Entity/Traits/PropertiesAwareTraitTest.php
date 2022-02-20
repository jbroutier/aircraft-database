<?php

declare(strict_types=1);

namespace Tests\Unit\Entity\Traits;

use App\Entity\Interface\PropertiesAwareInterface;
use App\Entity\PropertyValue;
use App\Entity\Traits\PropertiesAwareTrait;
use Doctrine\Common\Collections\ArrayCollection;
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
    /**
     * @testdox Method getPropertyGroups() returns an empty collection by default.
     */
    public function testGetPropertyGroups(): void
    {
        $entity = new PropertiesAwareEntity();

        self::assertEmpty($entity->getPropertyGroups());
    }

    /**
     * @testdox Method addPropertyValue() adds a property value.
     */
    public function testAddPropertyValue(): void
    {
        $propertyValue = \Mockery::mock(PropertyValue::class);

        $entity = new PropertiesAwareEntity();
        $entity->addPropertyValue($propertyValue);

        self::assertEquals($propertyValue, $entity->getPropertyValues()->first());
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
        $propertyValues = [
            \Mockery::mock(PropertyValue::class),
            \Mockery::mock(PropertyValue::class),
        ];

        $entity = new PropertiesAwareEntity();
        $entity->setPropertyValues($propertyValues);

        self::assertEquals($propertyValues, $entity->getPropertyValues()->toArray());
    }
}
