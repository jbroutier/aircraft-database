<?php

declare(strict_types=1);

namespace App\EventSubscriber;

use App\Entity\Picture;
use Liip\ImagineBundle\Message\WarmupCache;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Vich\UploaderBundle\Event\Event;
use Vich\UploaderBundle\Event\Events;

class UploaderEventSubscriber implements EventSubscriberInterface
{
    public function __construct(protected readonly MessageBusInterface $messageBus)
    {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            Events::POST_UPLOAD => 'onPostUpload',
        ];
    }

    public function onPostUpload(Event $event): void
    {
        $mapping = $event->getMapping();

        if ($mapping->getMappingName() === 'picture') {
            /** @var Picture $picture */
            $picture = $event->getObject();
            $this->messageBus->dispatch(new WarmupCache('pictures/' . $picture->getFileName()));
        }
    }
}
