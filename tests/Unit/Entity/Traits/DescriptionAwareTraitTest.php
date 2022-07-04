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
        self::assertNull((new DescriptionAwareEntity())->getDescription());
    }

    /**
     * @testdox Method setDescription() sets the description.
     */
    public function testSetDescription(): void
    {
        $entity = (new DescriptionAwareEntity())
            ->setDescription('Lockheed L-1049 Super Constellation');

        self::assertEquals('Lockheed L-1049 Super Constellation', $entity->getDescription());
    }
}
