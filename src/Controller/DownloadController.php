<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use WhiteOctober\BreadcrumbsBundle\Model\Breadcrumbs;

class DownloadController extends AbstractController
{
    public function __construct(
        protected readonly Breadcrumbs $breadcrumbs,
        #[Autowire(value: '%kernel.project_dir%/dump')]
        protected readonly string $directory
    ) {
    }

    #[Route(path: '/downloads/aircraft-models', name: 'download_aircraft_models')]
    public function aircraftModels(): Response
    {
        return new BinaryFileResponse($this->directory . '/aircraft-models.csv');
    }

    #[Route(path: '/downloads/aircraft-types', name: 'download_aircraft_types')]
    public function aircraftTypes(): Response
    {
        return new BinaryFileResponse($this->directory . '/aircraft-types.csv');
    }

    #[Route(path: '/downloads/engine-models', name: 'download_engine_models')]
    public function engineModels(): Response
    {
        return new BinaryFileResponse($this->directory . '/engine-models.csv');
    }

    #[Route(path: '/downloads', name: 'download_index')]
    public function index(): Response
    {
        $this->breadcrumbs->addItem('Home', $this->generateUrl('home'));
        $this->breadcrumbs->addItem('Downloads', $this->generateUrl('download_index'));

        return $this->render('download/index.html.twig');
    }

    #[Route(path: '/downloads/manufacturers', name: 'download_manufacturers')]
    public function manufacturers(): Response
    {
        return new BinaryFileResponse($this->directory . '/manufacturers.csv');
    }
}
