<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\Manufacturer;
use App\Repository\ManufacturerRepository;
use Cocur\Slugify\Slugify;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<Manufacturer>
 *
 * @method static Manufacturer|Proxy createOne(array $attributes = [])
 * @method static Manufacturer[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Manufacturer|Proxy find(object|array|mixed $criteria)
 * @method static Manufacturer|Proxy findOrCreate(array $attributes)
 * @method static Manufacturer|Proxy first(string $sortedField = 'id')
 * @method static Manufacturer|Proxy last(string $sortedField = 'id')
 * @method static Manufacturer|Proxy random(array $attributes = [])
 * @method static Manufacturer|Proxy randomOrCreate(array $attributes = [])
 * @method static Manufacturer[]|Proxy[] all()
 * @method static Manufacturer[]|Proxy[] findBy(array $attributes)
 * @method static Manufacturer[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static Manufacturer[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static ManufacturerRepository|RepositoryProxy repository()
 * @method Manufacturer|Proxy create(array|callable $attributes = [])
 */
class ManufacturerFactory extends ModelFactory
{
    /**
     * @return array<string, mixed>
     */
    protected function getDefaults(): array
    {
        return [
            'content' => self::faker()->optional(0.9)->paragraphs(self::faker()->numberBetween(1, 5), true),
            'createdAt' => \DateTimeImmutable::createFromMutable(self::faker()->dateTime()),
            'country' => self::faker()->optional(0.9)->countryCode(),
            'name' => self::faker()->unique()->company(),
        ];
    }

    protected function initialize(): ModelFactory
    {
        return $this->afterInstantiate(function (Manufacturer $manufacturer) {
            if (is_null($manufacturer->getSlug())) {
                $manufacturer->setSlug((new Slugify())->slugify((string)$manufacturer->getName()));
            }
        });
    }

    protected static function getClass(): string
    {
        return Manufacturer::class;
    }
}
