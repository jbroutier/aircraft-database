<?php

declare(strict_types=1);

namespace Tests\Unit\Entity\Traits;

use App\Entity\Interface\NameableInterface;
use App\Entity\Traits\NameableTrait;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PHPUnit\Framework\TestCase;

final class NameableEntity implements NameableInterface
{
    use NameableTrait;
}

final class NameableTraitTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    /**
     * @testdox Method getName() returns null by default.
     */
    public function testGetName(): void
    {
        $entity = new NameableEntity();

        self::assertNull($entity->getName());
    }

    /**
     * @testdox Method setName() sets the name.
     */
    public function testSetName(): void
    {
        $entity = new NameableEntity();
        $entity->setName('The Unnameable');

        self::assertEquals('The Unnameable', $entity->getName());
    }
}
