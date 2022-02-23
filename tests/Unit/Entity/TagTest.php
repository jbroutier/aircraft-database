<?php

declare(strict_types=1);

namespace Tests\Unit\Entity;

use App\Entity\Tag;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PHPUnit\Framework\TestCase;

final class TagTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    /**
     * @testdox Method getColor() returns null by default.
     */
    public function testGetColor(): void
    {
        $tag = new Tag();

        self::assertNull($tag->getColor());
    }

    /**
     * @testdox Method setColor() sets the color.
     */
    public function testSetColor(): void
    {
        $tag = new Tag();
        $tag->setColor('#c0ffee');

        self::assertEquals('#c0ffee', $tag->getColor());
    }

    /**
     * @testdox Method getIcon() returns null by default.
     */
    public function testGetIcon(): void
    {
        $tag = new Tag();

        self::assertNull($tag->getIcon());
    }

    /**
     * @testdox Method setIcon() sets the icon.
     */
    public function testSetIcon(): void
    {
        $tag = new Tag();
        $tag->setIcon('waffle');

        self::assertEquals('waffle', $tag->getIcon());
    }
}
