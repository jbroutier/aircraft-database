<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\AircraftType;
use App\Enum\AircraftFamily;
use App\Enum\EngineFamily;
use App\Repository\AircraftTypeRepository;
use Cocur\Slugify\Slugify;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<AircraftType>
 *
 * @method static AircraftType|Proxy createOne(array $attributes = [])
 * @method static AircraftType[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static AircraftType|Proxy find(object|array|mixed $criteria)
 * @method static AircraftType|Proxy findOrCreate(array $attributes)
 * @method static AircraftType|Proxy first(string $sortedField = 'id')
 * @method static AircraftType|Proxy last(string $sortedField = 'id')
 * @method static AircraftType|Proxy random(array $attributes = [])
 * @method static AircraftType|Proxy randomOrCreate(array $attributes = [])
 * @method static AircraftType[]|Proxy[] all()
 * @method static AircraftType[]|Proxy[] findBy(array $attributes)
 * @method static AircraftType[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static AircraftType[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static AircraftTypeRepository|RepositoryProxy repository()
 * @method AircraftType|Proxy create(array|callable $attributes = [])
 */
class AircraftTypeFactory extends ModelFactory
{
    /**
     * @return array<string, mixed>
     */
    protected function getDefaults(): array
    {
        return [
            'aircraftFamily' => self::faker()->randomElement(AircraftFamily::cases()),
            'content' => self::faker()->optional(0.9)->paragraphs(self::faker()->numberBetween(1, 5), true),
            'createdAt' => \DateTimeImmutable::createFromMutable(self::faker()->dateTime()),
            'engineCount' => self::faker()->numberBetween(1, 4),
            'engineFamily' => self::faker()->randomElement(EngineFamily::cases()),
            'iataCode' => self::faker()->optional(0.9)->regexify('[A-Z0-9]{3}'),
            'icaoCode' => self::faker()->optional(0.9)->regexify('[A-Z0-9]{2,4}'),
            'name' => self::faker()->unique()->passthrough(
                self::faker()->regexify('[A-Z][0-9]{1,3}') . ' ' . ucfirst(self::faker()->word())
            ),
        ];
    }

    protected function initialize(): ModelFactory
    {
        return $this->afterInstantiate(function (AircraftType $aircraftType) {
            if (is_null($aircraftType->getSlug())) {
                $aircraftType->setSlug((new Slugify())->slugify((string)$aircraftType->getName()));
            }
        });
    }

    protected static function getClass(): string
    {
        return AircraftType::class;
    }
}
