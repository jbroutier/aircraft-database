<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\Picture;
use App\Repository\PictureRepository;
use Composer\Spdx\SpdxLicenses;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<Picture>
 *
 * @method static Picture|Proxy createOne(array $attributes = [])
 * @method static Picture[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Picture|Proxy find(object|array|mixed $criteria)
 * @method static Picture|Proxy findOrCreate(array $attributes)
 * @method static Picture|Proxy first(string $sortedField = 'id')
 * @method static Picture|Proxy last(string $sortedField = 'id')
 * @method static Picture|Proxy random(array $attributes = [])
 * @method static Picture|Proxy randomOrCreate(array $attributes = [])
 * @method static Picture[]|Proxy[] all()
 * @method static Picture[]|Proxy[] findBy(array $attributes)
 * @method static Picture[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static Picture[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static PictureRepository|RepositoryProxy repository()
 * @method Picture|Proxy create(array|callable $attributes = [])
 */
class PictureFactory extends ModelFactory
{
    /**
     * @return array<string, mixed>
     */
    protected function getDefaults(): array
    {
        return [
            'authorName' => self::faker()->name(),
            'authorProfile' => self::faker()->optional(0.9)->url(),
            'description' => self::faker()->optional(0.9)->sentence(),
            'license' => self::faker()->randomElement(array_keys((new SpdxLicenses())->getLicenses())),
            'source' => self::faker()->url(),
        ];
    }

    protected static function getClass(): string
    {
        return Picture::class;
    }
}
