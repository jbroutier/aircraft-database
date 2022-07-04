<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\AircraftModel;
use App\Enum\AircraftFamily;
use App\Enum\EngineFamily;
use App\Repository\AircraftModelRepository;
use Cocur\Slugify\Slugify;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<AircraftModel>
 *
 * @method static AircraftModel|Proxy createOne(array $attributes = [])
 * @method static AircraftModel[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static AircraftModel|Proxy find(object|array|mixed $criteria)
 * @method static AircraftModel|Proxy findOrCreate(array $attributes)
 * @method static AircraftModel|Proxy first(string $sortedField = 'id')
 * @method static AircraftModel|Proxy last(string $sortedField = 'id')
 * @method static AircraftModel|Proxy random(array $attributes = [])
 * @method static AircraftModel|Proxy randomOrCreate(array $attributes = [])
 * @method static AircraftModel[]|Proxy[] all()
 * @method static AircraftModel[]|Proxy[] findBy(array $attributes)
 * @method static AircraftModel[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static AircraftModel[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static AircraftModelRepository|RepositoryProxy repository()
 * @method AircraftModel|Proxy create(array|callable $attributes = [])
 */
class AircraftModelFactory extends ModelFactory
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
            'name' => self::faker()->unique()->passthrough(
                self::faker()->regexify('[A-Z][0-9]{1,3}') . ' ' . ucfirst(self::faker()->word())
            ),
        ];
    }

    protected function initialize(): ModelFactory
    {
        return $this->afterInstantiate(function (AircraftModel $aircraftModel) {
            if (is_null($aircraftModel->getSlug())) {
                $aircraftModel->setSlug((new Slugify())->slugify((string)$aircraftModel->getName()));
            }
        });
    }

    protected static function getClass(): string
    {
        return AircraftModel::class;
    }
}
