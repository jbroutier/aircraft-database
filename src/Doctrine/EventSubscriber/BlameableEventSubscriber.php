<?php

declare(strict_types=1);

namespace App\Doctrine\EventSubscriber;

use App\Entity\Interface\BlameableInterface;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Events;
use Symfony\Component\Security\Core\Security;

class BlameableEventSubscriber implements EventSubscriber
{
    public function __construct(protected readonly Security $security)
    {
    }

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

        if ($entity instanceof BlameableInterface) {
            $entity->setCreatedBy($this->security->getUser());
        }
    }

    public function preUpdate(PreUpdateEventArgs $args): void
    {
        $entity = $args->getObject();

        if ($entity instanceof BlameableInterface) {
            $entity->setUpdatedBy($this->security->getUser());
        }
    }
}
