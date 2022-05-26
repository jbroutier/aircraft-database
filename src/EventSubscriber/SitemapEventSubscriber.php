<?php

declare(strict_types=1);

namespace App\EventSubscriber;

use App\Service\SitemapGenerator;
use Presta\SitemapBundle\Event\SitemapPopulateEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class SitemapEventSubscriber implements EventSubscriberInterface
{
    public function __construct(protected readonly SitemapGenerator $sitemapGenerator)
    {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            SitemapPopulateEvent::class => 'onSitemapPopulate',
        ];
    }

    public function onSitemapPopulate(SitemapPopulateEvent $event): void
    {
        if (in_array($event->getSection(), [null, 'aircraft-models'], true)) {
            $this->sitemapGenerator->generateAircraftModels($event->getUrlContainer());
        }

        if (in_array($event->getSection(), [null, 'aircraft-types'], true)) {
            $this->sitemapGenerator->generateAircraftTypes($event->getUrlContainer());
        }

        if (in_array($event->getSection(), [null, 'engine-models'], true)) {
            $this->sitemapGenerator->generateEngineModels($event->getUrlContainer());
        }

        if (in_array($event->getSection(), [null, 'manufacturers'], true)) {
            $this->sitemapGenerator->generateManufacturers($event->getUrlContainer());
        }
    }
}
