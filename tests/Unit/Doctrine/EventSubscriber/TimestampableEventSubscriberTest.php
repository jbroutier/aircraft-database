<?php

declare(strict_types=1);

namespace Tests\Unit\Doctrine\EventSubscriber;

use App\Doctrine\EventSubscriber\TimestampableEventSubscriber;
use App\Entity\Interface\TimestampableInterface;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PHPUnit\Framework\TestCase;

final class TimestampableEventSubscriberTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    /**
     * @testdox Method prePersist() sets the entity creation date and time.
     */
    public function testPrePersist(): void
    {
        $entity = \Mockery::mock(TimestampableInterface::class);
        $entity
            ->expects('setCreatedAt')
            ->once();

        $args = \Mockery::mock(LifecycleEventArgs::class);
        $args
            ->expects('getObject')
            ->once()
            ->andReturn($entity);

        $eventSubscriber = new TimestampableEventSubscriber();
        $eventSubscriber->prePersist($args);
    }

    /**
     * @testdox Method preUpdate() sets the entity modification date and time.
     */
    public function testPreUpdate(): void
    {
        $entity = \Mockery::mock(TimestampableInterface::class);
        $entity
            ->expects('setUpdatedAt')
            ->once();

        $args = \Mockery::mock(PreUpdateEventArgs::class);
        $args
            ->expects('getObject')
            ->once()
            ->andReturn($entity);

        $eventSubscriber = new TimestampableEventSubscriber();
        $eventSubscriber->preUpdate($args);
    }
}
