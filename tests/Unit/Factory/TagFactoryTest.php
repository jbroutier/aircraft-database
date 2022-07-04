<?php

declare(strict_types=1);

namespace Tests\Unit\Factory;

use App\Entity\Tag;
use App\Factory\TagFactory;
use PHPUnit\Framework\TestCase;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\Test\Factories;

final class TagFactoryTest extends TestCase
{
    use Factories;

    /**
     * @testdox Method createOne() returns an instance of Proxy<Tag>.
     */
    public function testCreate(): void
    {
        $tag = TagFactory::createOne();

        self::assertInstanceOf(Proxy::class, $tag);
    }

    /**
     * @testdox Method createOne() generates the slug from the name by default.
     */
    public function testCreateWithoutSlug(): void
    {
        /** @var Proxy<Tag> $tag */
        $tag = TagFactory::createOne(['name' => 'Retired']);

        self::assertEquals('retired', $tag->getSlug());
    }
}
