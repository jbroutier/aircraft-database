<?php

declare(strict_types=1);

namespace Tests\Unit\Entity\Traits;

use App\Entity\Interface\DescriptionAwareInterface;
use App\Entity\Traits\DescriptionAwareTrait;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PHPUnit\Framework\TestCase;

final class DescriptionAwareEntity implements DescriptionAwareInterface
{
    use DescriptionAwareTrait;
}

final class DescriptionAwareTraitTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    /**
     * @testdox Method getDescription() returns null by default.
     */
    public function testGetDescription(): void
    {
        $entity = new DescriptionAwareEntity();

        self::assertNull($entity->getDescription());
    }

    /**
     * @testdox Method setDescription() sets the description.
     */
    public function testSetDescription(): void
    {
        $entity = new DescriptionAwareEntity();
        $entity->setDescription('sapien pellentesque habitant morbi');

        self::assertEquals('sapien pellentesque habitant morbi', $entity->getDescription());
    }
}
