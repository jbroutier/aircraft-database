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
        protected readonly EntityManagerInterface $entityManager,
        protected readonly UrlGeneratorInterface $urlGenerator,
    ) {
    }

    public function generateAircraftModels(UrlContainerInterface $urlContainer): void
    {
        $aircraftModels = $this->entityManager
            ->getRepository(AircraftModel::class)
            ->findAll();

        foreach ($aircraftModels as $aircraftModel) {
            $url = $this->urlGenerator->generate(
                'database_aircraft_model_read',
                ['slug' => $aircraftModel->getSlug()],
                UrlGeneratorInterface::ABSOLUTE_URL
            );

            $lastmod = $aircraftModel->getUpdatedAt() ?? $aircraftModel->getCreatedAt();
            $urlContainer->addUrl(new UrlConcrete($url, $lastmod), 'aircraft_models');
        }
    }

    public function generateAircraftTypes(UrlContainerInterface $urlContainer): void
    {
        $aircraftTypes = $this->entityManager
            ->getRepository(AircraftType::class)
            ->findAll();

        foreach ($aircraftTypes as $aircraftType) {
            $url = $this->urlGenerator->generate(
                'database_aircraft_type_read',
                ['slug' => $aircraftType->getSlug()],
                UrlGeneratorInterface::ABSOLUTE_URL
            );

            $lastmod = $aircraftType->getUpdatedAt() ?? $aircraftType->getCreatedAt();
            $urlContainer->addUrl(new UrlConcrete($url, $lastmod), 'aircraft_types');
        }
    }

    public function generateEngineModels(UrlContainerInterface $urlContainer): void
    {
        $engineModels = $this->entityManager
            ->getRepository(EngineModel::class)
            ->findAll();

        foreach ($engineModels as $engineModel) {
            $url = $this->urlGenerator->generate(
                'database_engine_model_read',
                ['slug' => $engineModel->getSlug()],
                UrlGeneratorInterface::ABSOLUTE_URL
            );

            $lastmod = $engineModel->getUpdatedAt() ?? $engineModel->getCreatedAt();
            $urlContainer->addUrl(new UrlConcrete($url, $lastmod), 'engine_models');
        }
    }

    public function generateManufacturers(UrlContainerInterface $urlContainer): void
    {
        $manufacturers = $this->entityManager
            ->getRepository(Manufacturer::class)
            ->findAll();

        foreach ($manufacturers as $manufacturer) {
            $url = $this->urlGenerator->generate(
                'database_manufacturer_read',
                ['slug' => $manufacturer->getSlug()],
                UrlGeneratorInterface::ABSOLUTE_URL
            );

            $lastmod = $manufacturer->getUpdatedAt() ?? $manufacturer->getCreatedAt();
            $urlContainer->addUrl(new UrlConcrete($url, $lastmod), 'manufacturers');
        }
    }
}
