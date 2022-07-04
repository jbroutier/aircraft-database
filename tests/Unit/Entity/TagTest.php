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
        self::assertNull((new Tag())->getColor());
    }

    /**
     * @testdox Method setColor() sets the color.
     */
    public function testSetColor(): void
    {
        $tag = (new Tag())
            ->setColor('#f7db14');

        self::assertEquals('#f7db14', $tag->getColor());
    }
}
