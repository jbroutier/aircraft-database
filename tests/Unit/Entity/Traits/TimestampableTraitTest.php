<?php

declare(strict_types=1);

namespace Tests\Unit\Entity\Traits;

use App\Entity\Interface\TimestampableInterface;
use App\Entity\Traits\TimestampableTrait;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PHPUnit\Framework\TestCase;

final class TimestampableEntity implements TimestampableInterface
{
    use TimestampableTrait;
}

final class TimestampableTraitTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    /**
     * @testdox Method getCreatedAt() returns null by default.
     */
    public function testGetCreatedAt(): void
    {
        $entity = new TimestampableEntity();

        self::assertNull($entity->getCreatedAt());
    }

    /**
     * @testdox Method setCreatedAt() sets the creation date and time.
     */
    public function testSetCreatedAt(): void
    {
        $createdAt = new \DateTime();

        $entity = new TimestampableEntity();
        $entity->setCreatedAt($createdAt);

        self::assertEquals($createdAt, $entity->getCreatedAt());
    }

    /**
     * @testdox Method getUpdatedAt() returns null by default.
     */
    public function testGetUpdatedAt(): void
    {
        $entity = new TimestampableEntity();

        self::assertNull($entity->getUpdatedAt());
    }

    /**
     * @testdox Method setUpdatedAt() sets the modification date and time.
     */
    public function testSetUpdatedAt(): void
    {
        $updatedAt = new \DateTime();

        $entity = new TimestampableEntity();
        $entity->setUpdatedAt($updatedAt);

        self::assertEquals($updatedAt, $entity->getUpdatedAt());
    }
}
