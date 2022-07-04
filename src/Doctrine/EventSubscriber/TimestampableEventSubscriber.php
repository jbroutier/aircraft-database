<?php

declare(strict_types=1);

namespace App\Doctrine\EventSubscriber;

use App\Entity\Interface\TimestampableInterface;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Events;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;

#[AutoconfigureTag(name: 'doctrine.event_subscriber', attributes: ['connection' => 'default'])]
class TimestampableEventSubscriber implements EventSubscriber
{
    public function getSubscribedEvents(): array
    {
        return [
            Events::prePersist,
            Events::preUpdate,
        ];
    }

    public function prePersist(LifecycleEventArgs $args): void
    {
        $entity = $args->getObject();

        if ($entity instanceof TimestampableInterface && is_null($entity->getCreatedAt())) {
            $entity->setCreatedAt(new \DateTimeImmutable('now', new \DateTimeZone('UTC')));
        }
    }

    public function preUpdate(PreUpdateEventArgs $args): void
    {
        $entity = $args->getObject();

        if ($entity instanceof TimestampableInterface) {
            $entity->setUpdatedAt(new \DateTimeImmutable('now', new \DateTimeZone('UTC')));
        }
    }
}
