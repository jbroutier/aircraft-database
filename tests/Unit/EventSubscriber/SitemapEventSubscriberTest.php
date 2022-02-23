<?php

declare(strict_types=1);

namespace Tests\Unit\EventSubscriber;

use App\EventSubscriber\SitemapEventSubscriber;
use App\Service\SitemapGenerator;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PHPUnit\Framework\TestCase;
use Presta\SitemapBundle\Event\SitemapPopulateEvent;
use Presta\SitemapBundle\Service\UrlContainerInterface;

final class SitemapEventSubscriberTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    /**
     * @testdox Method onSitemapPopulate() calls the sitemap generator.
     */
    public function testOnSitemapPopulate(): void
    {
        $urlContainer = \Mockery::mock(UrlContainerInterface::class);

        $event = \Mockery::mock(SitemapPopulateEvent::class);
        $event
            ->expects('getSection')
            ->times(4)
            ->andReturn('aircraft-models', 'aircraft-types', 'engine-models', 'manufacturers');

        $event
            ->expects('getUrlContainer')
            ->times(4)
            ->andReturn($urlContainer);

        $sitemapGenerator = \Mockery::mock(SitemapGenerator::class);
        $sitemapGenerator
            ->expects('generateAircraftModels')
            ->once()
            ->with($urlContainer);

        $sitemapGenerator
            ->expects('generateAircraftTypes')
            ->once()
            ->with($urlContainer);

        $sitemapGenerator
            ->expects('generateEngineModels')
            ->once()
            ->with($urlContainer);

        $sitemapGenerator
            ->expects('generateManufacturers')
            ->once()
            ->with($urlContainer);

        $eventSubscriber = new SitemapEventSubscriber($sitemapGenerator);
        $eventSubscriber->onSitemapPopulate($event);
    }
}
