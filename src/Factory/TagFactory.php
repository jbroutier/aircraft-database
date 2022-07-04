<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\Tag;
use App\Repository\TagRepository;
use Cocur\Slugify\Slugify;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<Tag>
 *
 * @method static Tag|Proxy createOne(array $attributes = [])
 * @method static Tag[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Tag|Proxy find(object|array|mixed $criteria)
 * @method static Tag|Proxy findOrCreate(array $attributes)
 * @method static Tag|Proxy first(string $sortedField = 'id')
 * @method static Tag|Proxy last(string $sortedField = 'id')
 * @method static Tag|Proxy random(array $attributes = [])
 * @method static Tag|Proxy randomOrCreate(array $attributes = [])
 * @method static Tag[]|Proxy[] all()
 * @method static Tag[]|Proxy[] findBy(array $attributes)
 * @method static Tag[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static Tag[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static TagRepository|RepositoryProxy repository()
 * @method Tag|Proxy create(array|callable $attributes = [])
 */
class TagFactory extends ModelFactory
{
    /**
     * @return array<string, mixed>
     */
    protected function getDefaults(): array
    {
        return [
            'color' => self::faker()->hexColor(),
            'createdAt' => \DateTimeImmutable::createFromMutable(self::faker()->dateTime()),
            'description' => self::faker()->optional(0.9)->sentence(),
            'name' => ucfirst(self::faker()->unique()->word()),
        ];
    }

    protected function initialize(): ModelFactory
    {
        return $this->afterInstantiate(function (Tag $tag) {
            if (is_null($tag->getSlug())) {
                $slugify = new Slugify();
                $tag->setSlug($slugify->slugify((string)$tag->getName()));
            }
        });
    }

    protected static function getClass(): string
    {
        return Tag::class;
    }
}
