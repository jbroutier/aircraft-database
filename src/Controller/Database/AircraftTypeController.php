<?php

declare(strict_types=1);

namespace App\Controller\Database;

use App\Form\AircraftTypeQueryType;
use App\Repository\AircraftTypeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use WhiteOctober\BreadcrumbsBundle\Model\Breadcrumbs;

class AircraftTypeController extends AbstractController
{
    public function __construct(
        protected AircraftTypeRepository $repository,
        protected Breadcrumbs $breadcrumbs
    ) {
    }

    #[Route(path: '/database/aircraft-types', name: 'database_aircraft_type_list')]
    public function list(Request $request): Response
    {
        $this->breadcrumbs->addItem('Index', $this->generateUrl('index'));
        $this->breadcrumbs->addItem('Aircraft types', $this->generateUrl('database_aircraft_type_list'));

        $form = $this->createForm(AircraftTypeQueryType::class, null, ['method' => 'GET']);
        $form->handleRequest($request);

        $aircraftTypes = $this->repository
            ->findPaginated($form->getData()['filters'] ?? [], $form->getData()['order'] ?? ['name' => 'ASC'])
            ->setMaxPerPage(12)
            ->setCurrentPage(max($request->query->getInt('page', 1), 1));

        return $this->render('database/aircraft_type/list.html.twig', [
            'aircraftTypes' => $aircraftTypes,
            'form' => $form->createView(),
        ]);
    }

    #[Route(path: '/database/aircraft-types/{slug}', name: 'database_aircraft_type_read')]
    public function read(Request $request): Response
    {
        $slug = $request->attributes->get('slug');

        if (is_null($aircraftType = $this->repository->findOneBy(['slug' => $slug]))) {
            throw new NotFoundHttpException();
        }

        $this->breadcrumbs->addItem('Index', $this->generateUrl('index'));
        $this->breadcrumbs->addItem('Aircraft types', $this->generateUrl('database_aircraft_type_list'));
        $this->breadcrumbs->addItem(
            (string)$aircraftType->getName(),
            $this->generateUrl('database_aircraft_type_read', ['slug' => $aircraftType->getSlug()])
        );

        $aircraftModels = $aircraftType
            ->getAircraftModelsPaginated()
            ->setMaxPerPage(4)
            ->setCurrentPage(max($request->query->getInt('aircraftModelsPage', 1), 1));

        $engineModels = $aircraftType
            ->getEngineModelsPaginated()
            ->setMaxPerPage(4)
            ->setCurrentPage(max($request->query->getInt('engineModelsPage', 1), 1));

        return $this->render('database/aircraft_type/read.html.twig', [
            'aircraftModels' => $aircraftModels,
            'aircraftType' => $aircraftType,
            'engineModels' => $engineModels,
        ]);
    }
}
