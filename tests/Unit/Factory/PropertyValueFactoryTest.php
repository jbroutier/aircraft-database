<?php

declare(strict_types=1);

namespace Tests\Unit\Factory;

use App\Entity\PropertyValue;
use App\Enum\PropertyType;
use App\Factory\PropertyFactory;
use App\Factory\PropertyValueFactory;
use PHPUnit\Framework\TestCase;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\Test\Factories;

final class PropertyValueFactoryTest extends TestCase
{
    use Factories;

    /**
     * @testdox Method createOne() returns an instance of Proxy<PropertyValue>.
     */
    public function testCreate(): void
    {
        $propertyValue = PropertyValueFactory::createOne([
            'property' => PropertyFactory::createOne(),
        ]);

        self::assertInstanceOf(Proxy::class, $propertyValue);
    }

    /**
     * @testdox Method createOne() throws when called without a property.
     */
    public function testCreateWithoutProperty(): void
    {
        self::expectExceptionMessage('Unhandled property type.');

        PropertyValueFactory::createOne();
    }

    /**
     * @testdox Method createOne() creates a boolean value when called with a boolean type property.
     */
    public function testCreateWithBooleanProperty(): void
    {
        /** @var Proxy<PropertyValue> $propertyValue */
        $propertyValue = PropertyValueFactory::createOne([
            'property' => PropertyFactory::createOne([
                'type' => PropertyType::Boolean,
            ]),
        ]);

        self::assertMatchesRegularExpression('/^true|false$/', (string)$propertyValue->getValue());
    }

    /**
     * @testdox Method createOne() creates a date value when called with a date type property.
     */
    public function testCreateWithDateProperty(): void
    {
        /** @var Proxy<PropertyValue> $propertyValue */
        $propertyValue = PropertyValueFactory::createOne([
            'property' => PropertyFactory::createOne([
                'type' => PropertyType::Date,
            ]),
        ]);

        self::assertMatchesRegularExpression('/^\d{4}-\d{2}-\d{2}$/', (string)$propertyValue->getValue());
    }

    /**
     * @testdox Method createOne() creates a float value when called with a float type property.
     */
    public function testCreateWithFloatProperty(): void
    {
        /** @var Proxy<PropertyValue> $propertyValue */
        $propertyValue = PropertyValueFactory::createOne([
            'property' => PropertyFactory::createOne([
                'type' => PropertyType::Float,
            ]),
        ]);

        self::assertMatchesRegularExpression('/^\d+(\.\d+)?$/', (string)$propertyValue->getValue());
    }

    /**
     * @testdox Method createOne() creates an integer value when called with an integer type property.
     */
    public function testCreateWithIntegerProperty(): void
    {
        /** @var Proxy<PropertyValue> $propertyValue */
        $propertyValue = PropertyValueFactory::createOne([
            'property' => PropertyFactory::createOne([
                'type' => PropertyType::Integer,
            ]),
        ]);

        self::assertMatchesRegularExpression('/^\d+$/', (string)$propertyValue->getValue());
    }

    /**
     * @testdox Method createOne() creates a string value when called with a string type property.
     */
    public function testCreateWithStringProperty(): void
    {
        /** @var Proxy<PropertyValue> $propertyValue */
        $propertyValue = PropertyValueFactory::createOne([
            'property' => PropertyFactory::createOne([
                'type' => PropertyType::String,
            ]),
        ]);

        self::assertMatchesRegularExpression('/^[\w\s]+$/', (string)$propertyValue->getValue());
    }

    /**
     * @testdox Method createOne() creates an url value when called with an url type property.
     */
    public function testCreateWithUrlProperty(): void
    {
        /** @var Proxy<PropertyValue> $propertyValue */
        $propertyValue = PropertyValueFactory::createOne([
            'property' => PropertyFactory::createOne([
                'type' => PropertyType::Url,
            ]),
        ]);

        self::assertMatchesRegularExpression('/^https?:\/\/[\w.\-\/]+$/', (string)$propertyValue->getValue());
    }
}
