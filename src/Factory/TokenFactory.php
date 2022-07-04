<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\Token;
use App\Repository\TokenRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<Token>
 *
 * @method static Token|Proxy createOne(array $attributes = [])
 * @method static Token[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Token|Proxy find(object|array|mixed $criteria)
 * @method static Token|Proxy findOrCreate(array $attributes)
 * @method static Token|Proxy first(string $sortedField = 'id')
 * @method static Token|Proxy last(string $sortedField = 'id')
 * @method static Token|Proxy random(array $attributes = [])
 * @method static Token|Proxy randomOrCreate(array $attributes = [])
 * @method static Token[]|Proxy[] all()
 * @method static Token[]|Proxy[] findBy(array $attributes)
 * @method static Token[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static Token[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static TokenRepository|RepositoryProxy repository()
 * @method Token|Proxy create(array|callable $attributes = [])
 */
class TokenFactory extends ModelFactory
{
    /**
     * @return array<string, mixed>
     */
    protected function getDefaults(): array
    {
        return [
            'expiresAt' => \DateTimeImmutable::createFromMutable(self::faker()->dateTimeBetween('now', '1 day')),
            'token' => self::faker()->regexify('[0-9a-f]{32}'),
        ];
    }

    protected static function getClass(): string
    {
        return Token::class;
    }
}
