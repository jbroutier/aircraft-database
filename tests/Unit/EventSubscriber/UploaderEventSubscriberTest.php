<?php

declare(strict_types=1);

namespace Tests\Unit\EventSubscriber;

use App\Entity\Picture;
use App\EventSubscriber\UploaderEventSubscriber;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBusInterface;
use Vich\UploaderBundle\Event\Event;
use Vich\UploaderBundle\Mapping\PropertyMapping;

final class UploaderEventSubscriberTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    /**
     * @testdox Method onPostUpload() dispatches the message triggering the cache warmup.
     */
    public function testOnPostUpload(): void
    {
        $messageBus = \Mockery::mock(MessageBusInterface::class);
        $messageBus
            ->expects('dispatch')
            ->once()
            ->andReturn(new Envelope(new \stdClass()));

        $mapping = \Mockery::mock(PropertyMapping::class);
        $mapping
            ->expects('getMappingName')
            ->once()
            ->andReturn('picture');

        $picture = \Mockery::mock(Picture::class);
        $picture
            ->expects('getFileName')
            ->once()
            ->andReturn('c46b64f0-35f8-4473-8358-d6e2109c9ff0.jpg');

        $event = \Mockery::mock(Event::class);
        $event
            ->expects('getMapping')
            ->once()
            ->andReturn($mapping);

        $event
            ->expects('getObject')
            ->once()
            ->andReturn($picture);

        $eventSubscriber = new UploaderEventSubscriber($messageBus);
        $eventSubscriber->onPostUpload($event);
    }
}
