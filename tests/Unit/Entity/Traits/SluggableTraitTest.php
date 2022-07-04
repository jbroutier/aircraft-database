<?php

declare(strict_types=1);

namespace Tests\Unit\Entity\Traits;

use App\Entity\Interface\SluggableInterface;
use App\Entity\Traits\SluggableTrait;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PHPUnit\Framework\TestCase;

final class SluggableEntity implements SluggableInterface
{
    use SluggableTrait;
}

final class SluggableTraitTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    /**
     * @testdox Method getSlug() returns null by default.
     */
    public function testGetSlug(): void
    {
        self::assertNull((new SluggableEntity())->getSlug());
    }

    /**
     * @testdox Method setSlug() sets the slug.
     */
    public function testSetSlug(): void
    {
        $entity = (new SluggableEntity())
            ->setSlug('s-64-skycrane');

        self::assertEquals('s-64-skycrane', $entity->getSlug());
    }
}
