<?php

declare(strict_types=1);

namespace Tests\Unit\Entity\Traits;

use App\Entity\Interface\BlameableInterface;
use App\Entity\Traits\BlameableTrait;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Security\Core\User\UserInterface;

final class BlameableEntity implements BlameableInterface
{
    use BlameableTrait;
}

final class BlameableTraitTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    /**
     * @testdox Method getCreatedBy() returns null by default.
     */
    public function testGetCreatedBy(): void
    {
        self::assertNull((new BlameableEntity())->getCreatedBy());
    }

    /**
     * @testdox Method setCreatedBy() sets the user who created the entity.
     */
    public function testSetCreatedBy(): void
    {
        $user = \Mockery::mock(UserInterface::class);

        $entity = (new BlameableEntity())
            ->setCreatedBy($user);

        self::assertEquals($user, $entity->getCreatedBy());
    }

    /**
     * @testdox Method getUpdatedBy() returns null by default.
     */
    public function testGetUpdatedBy(): void
    {
        self::assertNull((new BlameableEntity())->getUpdatedBy());
    }

    /**
     * @testdox Method setUpdatedBy() sets the user who updated the entity.
     */
    public function testSetUpdatedBy(): void
    {
        $user = \Mockery::mock(UserInterface::class);

        $entity = (new BlameableEntity())
            ->setUpdatedBy($user);

        self::assertEquals($user, $entity->getUpdatedBy());
    }
}
