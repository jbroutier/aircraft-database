<?php

declare(strict_types=1);

namespace Tests\Unit\Doctrine\EventSubscriber;

use App\Doctrine\EventSubscriber\BlameableEventSubscriber;
use App\Entity\Interface\BlameableInterface;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;

final class BlameableEventSubscriberTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    /**
     * @testdox Method prePersist() sets the user who created the entity.
     */
    public function testPrePersist(): void
    {
        $user = \Mockery::mock(UserInterface::class);

        $entity = \Mockery::mock(BlameableInterface::class);
        $entity
            ->expects('setCreatedBy')
            ->once()
            ->with($user);

        $security = \Mockery::mock(Security::class);
        $security
            ->expects('getUser')
            ->once()
            ->andReturn($user);

        $args = \Mockery::mock(LifecycleEventArgs::class);
        $args
            ->expects('getObject')
            ->once()
            ->andReturn($entity);

        $eventSubscriber = new BlameableEventSubscriber($security);
        $eventSubscriber->prePersist($args);
    }

    /**
     * @testdox Method preUpdate() sets the user who updated the entity.
     */
    public function testPreUpdate(): void
    {
        $user = \Mockery::mock(UserInterface::class);

        $entity = \Mockery::mock(BlameableInterface::class);
        $entity
            ->expects('setUpdatedBy')
            ->once()
            ->with($user);

        $security = \Mockery::mock(Security::class);
        $security
            ->expects('getUser')
            ->once()
            ->andReturn($user);

        $args = \Mockery::mock(PreUpdateEventArgs::class);
        $args
            ->expects('getObject')
            ->once()
            ->andReturn($entity);

        $eventSubscriber = new BlameableEventSubscriber($security);
        $eventSubscriber->preUpdate($args);
    }
}
