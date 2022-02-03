<?php

declare(strict_types=1);

namespace App\Controller\Database;

use App\Form\AircraftModelQueryType;
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
        protected AircraftModelRepository $repository,
        protected Breadcrumbs $breadcrumbs
    ) {
    }

    #[Route(path: '/database/aircraft-models', name: 'database_aircraft_model_list')]
    public function list(Request $request): Response
    {
        $this->breadcrumbs->addItem('Index', $this->generateUrl('index'));
        $this->breadcrumbs->addItem('Aircraft models', $this->generateUrl('database_aircraft_model_list'));

        $form = $this->createForm(AircraftModelQueryType::class, null, ['method' => 'GET']);
        $form->handleRequest($request);

        $aircraftModels = $this->repository
            ->findPaginated($form->getData()['filters'] ?? [], $form->getData()['order'] ?? ['name' => 'ASC'])
            ->setMaxPerPage(12)
            ->setCurrentPage(max($request->query->getInt('page', 1), 1));

        return $this->render('database/aircraft_model/list.html.twig', [
            'aircraftModels' => $aircraftModels,
            'form' => $form->createView(),
        ]);
    }

    #[Route(path: '/database/aircraft-models/{slug}', name: 'database_aircraft_model_read')]
    public function read(Request $request): Response
    {
        $slug = $request->attributes->get('slug');

        if (is_null($aircraftModel = $this->repository->findOneBy(['slug' => $slug]))) {
            throw new NotFoundHttpException();
        }

        $this->breadcrumbs->addItem('Index', $this->generateUrl('index'));
        $this->breadcrumbs->addItem('Aircraft models', $this->generateUrl('database_aircraft_model_list'));
        $this->breadcrumbs->addItem(
            (string)$aircraftModel->getName(),
            $this->generateUrl('database_aircraft_model_read', ['slug' => $aircraftModel->getSlug()])
        );

        $engineModels = $aircraftModel
            ->getEngineModelsPaginated()
            ->setMaxPerPage(4)
            ->setCurrentPage(max($request->query->getInt('engineModelsPage', 1), 1));

        return $this->render('database/aircraft_model/read.html.twig', [
            'aircraftModel' => $aircraftModel,
            'engineModels' => $engineModels,
        ]);
    }
}
