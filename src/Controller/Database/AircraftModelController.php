<?php

declare(strict_types=1);

namespace App\Controller\Database;

use App\Repository\AircraftModelRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use WhiteOctober\BreadcrumbsBundle\Model\Breadcrumbs;

class AircraftModelController extends AbstractController
{
    public function __construct(
        protected readonly AircraftModelRepository $repository,
        protected readonly Breadcrumbs $breadcrumbs
    ) {
    }

    #[Route(path: '/database/aircraft-models/{slug}', name: 'database_aircraft_model_read')]
    public function read(Request $request): Response
    {
        $slug = $request->attributes->get('slug');

        if (is_null($aircraftModel = $this->repository->findOneBy(['slug' => $slug]))) {
            throw new NotFoundHttpException();
        }

        $this->breadcrumbs->addItem('Home', $this->generateUrl('home'));
        $this->breadcrumbs->addItem('Aircraft types', $this->generateUrl('database_aircraft_type_list'));

        if (!is_null($aircraftType = $aircraftModel->getAircraftType())) {
            $this->breadcrumbs->addItem(
                $aircraftType->getManufacturer()?->getName() . ' ' . $aircraftType->getName(),
                $this->generateUrl('database_aircraft_type_read', ['slug' => $aircraftType->getSlug()])
            );
        }

        $this->breadcrumbs->addItem(
            $aircraftModel->getManufacturer()?->getName() . ' ' . $aircraftModel->getName(),
            $this->generateUrl('database_aircraft_model_read', ['slug' => $aircraftModel->getSlug()])
        );

        return $this->render('database/aircraft_model/read.html.twig', [
            'aircraftModel' => $aircraftModel,
        ]);
    }
}
