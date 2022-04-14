<?php

declare(strict_types=1);

namespace App\EventSubscriber;

use Sentry\SentrySdk;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class SentryEventSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::RESPONSE => 'onKernelResponse',
        ];
    }

    public function onKernelResponse(ResponseEvent $event): void
    {
        $transaction = SentrySdk::getCurrentHub()->getTransaction();

        if (!is_null($transaction) && $transaction->getSampled()) {
            if (!is_null($routeName = $event->getRequest()->attributes->get('_route'))) {
                $transaction->setName($routeName);
            }
        }
    }
}
