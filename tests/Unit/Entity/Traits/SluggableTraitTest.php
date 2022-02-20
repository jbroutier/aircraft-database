<?php

declare(strict_types=1);

namespace Tests\Unit\Entity\Traits;

use App\Entity\Interface\SluggableInterface;
use App\Entity\Traits\SluggableTrait;
use PHPUnit\Framework\TestCase;

final class SluggableEntity implements SluggableInterface
{
    use SluggableTrait;
}

final class SluggableTraitTest extends TestCase
{
    /**
     * @testdox Method getSlug() returns null by default.
     */
    public function testGetSlug(): void
    {
        $entity = new SluggableEntity();

        self::assertNull($entity->getSlug());
    }

    /**
     * @testdox Method setSlug() sets the slug.
     * @noinspection SpellCheckingInspection
     */
    public function testSetSlug(): void
    {
        $entity = new SluggableEntity();
        $entity->setSlug('odio-euismod-lacinia-at-quis');

        self::assertEquals('odio-euismod-lacinia-at-quis', $entity->getSlug());
    }
}
