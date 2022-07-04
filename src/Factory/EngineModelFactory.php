<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\EngineModel;
use App\Enum\EngineFamily;
use App\Repository\EngineModelRepository;
use Cocur\Slugify\Slugify;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<EngineModel>
 *
 * @method static EngineModel|Proxy createOne(array $attributes = [])
 * @method static EngineModel[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static EngineModel|Proxy find(object|array|mixed $criteria)
 * @method static EngineModel|Proxy findOrCreate(array $attributes)
 * @method static EngineModel|Proxy first(string $sortedField = 'id')
 * @method static EngineModel|Proxy last(string $sortedField = 'id')
 * @method static EngineModel|Proxy random(array $attributes = [])
 * @method static EngineModel|Proxy randomOrCreate(array $attributes = [])
 * @method static EngineModel[]|Proxy[] all()
 * @method static EngineModel[]|Proxy[] findBy(array $attributes)
 * @method static EngineModel[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static EngineModel[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static EngineModelRepository|RepositoryProxy repository()
 * @method EngineModel|Proxy create(array|callable $attributes = [])
 */
class EngineModelFactory extends ModelFactory
{
    /**
     * @return array<string, mixed>
     */
    protected function getDefaults(): array
    {
        return [
            'content' => self::faker()->optional(0.9)->paragraphs(self::faker()->numberBetween(1, 5), true),
            'createdAt' => \DateTimeImmutable::createFromMutable(self::faker()->dateTime()),
            'engineFamily' => self::faker()->randomElement(EngineFamily::cases()),
            'name' => self::faker()->unique()->regexify('[A-Z][0-9]{1,3}\-[0-9A-Z]{2,4}'),
        ];
    }

    protected function initialize(): ModelFactory
    {
        return $this->afterInstantiate(function (EngineModel $engineModel) {
            if (is_null($engineModel->getSlug())) {
                $engineModel->setSlug((new Slugify())->slugify((string)$engineModel->getName()));
            }
        });
    }

    protected static function getClass(): string
    {
        return EngineModel::class;
    }
}
