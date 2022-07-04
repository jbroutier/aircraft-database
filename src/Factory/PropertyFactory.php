<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\Property;
use App\Enum\PropertyType;
use App\Enum\PropertyUnit;
use App\Repository\PropertyRepository;
use Cocur\Slugify\Slugify;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<Property>
 *
 * @method static Property|Proxy createOne(array $attributes = [])
 * @method static Property[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Property|Proxy find(object|array|mixed $criteria)
 * @method static Property|Proxy findOrCreate(array $attributes)
 * @method static Property|Proxy first(string $sortedField = 'id')
 * @method static Property|Proxy last(string $sortedField = 'id')
 * @method static Property|Proxy random(array $attributes = [])
 * @method static Property|Proxy randomOrCreate(array $attributes = [])
 * @method static Property[]|Proxy[] all()
 * @method static Property[]|Proxy[] findBy(array $attributes)
 * @method static Property[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static Property[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static PropertyRepository|RepositoryProxy repository()
 * @method Property|Proxy create(array|callable $attributes = [])
 */
class PropertyFactory extends ModelFactory
{
    /**
     * @return array<string, mixed>
     */
    protected function getDefaults(): array
    {
        return [
            'createdAt' => \DateTimeImmutable::createFromMutable(self::faker()->dateTime()),
            'description' => self::faker()->optional(0.9)->sentence(),
            'name' => ucfirst(self::faker()->unique()->word()),
            'type' => self::faker()->randomElement(PropertyType::cases()),
        ];
    }

    protected function initialize(): ModelFactory
    {
        return $this->afterInstantiate(function (Property $property) {
            if (is_null($property->getSlug())) {
                $property->setSlug((new Slugify())->slugify((string)$property->getName()));
            }

            if (in_array($property->getType(), [PropertyType::Float, PropertyType::Integer], true)) {
                /** @var PropertyUnit|null $unit */
                $unit = self::faker()->optional()->randomElement(PropertyUnit::cases());
                $property->setUnit($unit);
            }
        });
    }

    protected static function getClass(): string
    {
        return Property::class;
    }
}
