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
    public function __construct(protected MessageBusInterface $messageBus)
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
        /** @var Picture */
        $picture = $event->getObject();
        $this->messageBus->dispatch(new WarmupCache('pictures/' . $picture->getFileName()));
    }
}
