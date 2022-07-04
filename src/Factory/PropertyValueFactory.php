<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\PropertyValue;
use App\Enum\PropertyType;
use App\Repository\PropertyValueRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<PropertyValue>
 *
 * @method static PropertyValue|Proxy createOne(array $attributes = [])
 * @method static PropertyValue[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static PropertyValue|Proxy find(object|array|mixed $criteria)
 * @method static PropertyValue|Proxy findOrCreate(array $attributes)
 * @method static PropertyValue|Proxy first(string $sortedField = 'id')
 * @method static PropertyValue|Proxy last(string $sortedField = 'id')
 * @method static PropertyValue|Proxy random(array $attributes = [])
 * @method static PropertyValue|Proxy randomOrCreate(array $attributes = [])
 * @method static PropertyValue[]|Proxy[] all()
 * @method static PropertyValue[]|Proxy[] findBy(array $attributes)
 * @method static PropertyValue[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static PropertyValue[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static PropertyValueRepository|RepositoryProxy repository()
 * @method PropertyValue|Proxy create(array|callable $attributes = [])
 */
class PropertyValueFactory extends ModelFactory
{
    /**
     * @return array<string, mixed>
     */
    protected function getDefaults(): array
    {
        return [
            'createdAt' => \DateTimeImmutable::createFromMutable(self::faker()->dateTime()),
        ];
    }

    protected function initialize(): ModelFactory
    {
        return $this->afterInstantiate(function (PropertyValue $propertyValue) {
            if (is_null($propertyValue->getValue())) {
                $value = (string)match ($propertyValue->getProperty()?->getType()) {
                    PropertyType::Boolean => self::faker()->boolean() ? 'true' : 'false',
                    PropertyType::Date => self::faker()->dateTime()->format('Y-m-d'),
                    PropertyType::Float => self::faker()->randomFloat(),
                    PropertyType::Integer => self::faker()->randomNumber(),
                    PropertyType::String => self::faker()->word(),
                    PropertyType::Url => self::faker()->url(),
                    default => throw new \RuntimeException('Unhandled property type.')
                };

                $propertyValue->setValue($value);
            }
        });
    }

    protected static function getClass(): string
    {
        return PropertyValue::class;
    }
}
