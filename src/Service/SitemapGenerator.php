<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\AircraftModel;
use App\Entity\AircraftType;
use App\Entity\EngineModel;
use App\Entity\Manufacturer;
use Doctrine\ORM\EntityManagerInterface;
use Presta\SitemapBundle\Service\UrlContainerInterface;
use Presta\SitemapBundle\Sitemap\Url\UrlConcrete;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class SitemapGenerator
{
    public function __construct(
        protected EntityManagerInterface $entityManager,
        protected UrlGeneratorInterface $urlGenerator,
    ) {
    }

    public function generateAircraftModels(UrlContainerInterface $urlContainer): void
    {
        $aircraftModels = $this->entityManager
            ->getRepository(AircraftModel::class)
            ->findAll();

        foreach ($aircraftModels as $aircraftModel) {
            $url = $this->urlGenerator->generate(
                'database_aircraft_model',
                ['slug' => $aircraftModel->getSlug()],
                UrlGeneratorInterface::ABSOLUTE_URL
            );

            $urlContainer->addUrl(new UrlConcrete($url), 'aircraft_models');
        }
    }

    public function generateAircraftTypes(UrlContainerInterface $urlContainer): void
    {
        $aircraftTypes = $this->entityManager
            ->getRepository(AircraftType::class)
            ->findAll();

        foreach ($aircraftTypes as $aircraftType) {
            $url = $this->urlGenerator->generate(
                'database_aircraft_type',
                ['slug' => $aircraftType->getSlug()],
                UrlGeneratorInterface::ABSOLUTE_URL
            );

            $urlContainer->addUrl(new UrlConcrete($url), 'aircraft_types');
        }
    }

    public function generateEngineModels(UrlContainerInterface $urlContainer): void
    {
        $engineModels = $this->entityManager
            ->getRepository(EngineModel::class)
            ->findAll();

        foreach ($engineModels as $engineModel) {
            $url = $this->urlGenerator->generate(
                'database_engine_model',
                ['slug' => $engineModel->getSlug()],
                UrlGeneratorInterface::ABSOLUTE_URL
            );

            $urlContainer->addUrl(new UrlConcrete($url), 'engine_models');
        }
    }

    public function generateManufacturers(UrlContainerInterface $urlContainer): void
    {
        $manufacturers = $this->entityManager
            ->getRepository(Manufacturer::class)
            ->findAll();

        foreach ($manufacturers as $manufacturer) {
            $url = $this->urlGenerator->generate(
                'database_manufacturer',
                ['slug' => $manufacturer->getSlug()],
                UrlGeneratorInterface::ABSOLUTE_URL
            );

            $urlContainer->addUrl(new UrlConcrete($url), 'manufacturers');
        }
    }
}
