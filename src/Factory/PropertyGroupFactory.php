<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\PropertyGroup;
use App\Repository\PropertyGroupRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<PropertyGroup>
 *
 * @method static PropertyGroup|Proxy createOne(array $attributes = [])
 * @method static PropertyGroup[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static PropertyGroup|Proxy find(object|array|mixed $criteria)
 * @method static PropertyGroup|Proxy findOrCreate(array $attributes)
 * @method static PropertyGroup|Proxy first(string $sortedField = 'id')
 * @method static PropertyGroup|Proxy last(string $sortedField = 'id')
 * @method static PropertyGroup|Proxy random(array $attributes = [])
 * @method static PropertyGroup|Proxy randomOrCreate(array $attributes = [])
 * @method static PropertyGroup[]|Proxy[] all()
 * @method static PropertyGroup[]|Proxy[] findBy(array $attributes)
 * @method static PropertyGroup[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static PropertyGroup[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static PropertyGroupRepository|RepositoryProxy repository()
 * @method PropertyGroup|Proxy create(array|callable $attributes = [])
 */
class PropertyGroupFactory extends ModelFactory
{
    /**
     * @return array<string, mixed>
     */
    protected function getDefaults(): array
    {
        return [
            'createdAt' => \DateTimeImmutable::createFromMutable(self::faker()->dateTime()),
            'name' => ucfirst(self::faker()->unique()->word()),
        ];
    }

    protected static function getClass(): string
    {
        return PropertyGroup::class;
    }
}
