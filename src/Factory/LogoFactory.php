<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\Logo;
use App\Repository\LogoRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<Logo>
 *
 * @method static Logo|Proxy createOne(array $attributes = [])
 * @method static Logo[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Logo|Proxy find(object|array|mixed $criteria)
 * @method static Logo|Proxy findOrCreate(array $attributes)
 * @method static Logo|Proxy first(string $sortedField = 'id')
 * @method static Logo|Proxy last(string $sortedField = 'id')
 * @method static Logo|Proxy random(array $attributes = [])
 * @method static Logo|Proxy randomOrCreate(array $attributes = [])
 * @method static Logo[]|Proxy[] all()
 * @method static Logo[]|Proxy[] findBy(array $attributes)
 * @method static Logo[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static Logo[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static LogoRepository|RepositoryProxy repository()
 * @method Logo|Proxy create(array|callable $attributes = [])
 */
class LogoFactory extends ModelFactory
{
    /**
     * @return array<string, mixed>
     */
    protected function getDefaults(): array
    {
        return [];
    }

    protected static function getClass(): string
    {
        return Logo::class;
    }
}
