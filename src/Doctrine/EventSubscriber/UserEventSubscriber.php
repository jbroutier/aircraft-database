<?php

declare(strict_types=1);

namespace App\Doctrine\EventSubscriber;

use App\Entity\User;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Events;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AutoconfigureTag(name: 'doctrine.event_subscriber', attributes: ['connection' => 'default'])]
class UserEventSubscriber implements EventSubscriber
{
    public function __construct(protected readonly UserPasswordHasherInterface $userPasswordHasher)
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

        if ($entity instanceof User) {
            $this->hashUserPassword($entity);
        }
    }

    public function preUpdate(PreUpdateEventArgs $args): void
    {
        $entity = $args->getObject();

        if ($entity instanceof User) {
            $this->hashUserPassword($entity);
        }
    }

    protected function hashUserPassword(User $user): void
    {
        if (!is_null($plainPassword = $user->getPlainPassword())) {
            $password = $this->userPasswordHasher->hashPassword($user, $plainPassword);
            $user
                ->setPassword($password)
                ->eraseCredentials();
        }
    }
}
