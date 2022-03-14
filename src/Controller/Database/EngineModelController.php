<?php

declare(strict_types=1);

namespace App\Controller\Database;

use App\Form\EngineModelQueryType;
use App\Repository\EngineModelRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use WhiteOctober\BreadcrumbsBundle\Model\Breadcrumbs;

class EngineModelController extends AbstractController
{
    public function __construct(
        protected Breadcrumbs $breadcrumbs,
        protected EngineModelRepository $repository
    ) {
    }

    #[Route(path: '/database/engine-models', name: 'database_engine_model_list')]
    public function list(Request $request): Response
    {
        $this->breadcrumbs->addItem('Index', $this->generateUrl('index'));
        $this->breadcrumbs->addItem('Engine models', $this->generateUrl('database_engine_model_list'));

        $form = $this->createForm(EngineModelQueryType::class, null, ['method' => 'GET']);
        $form->handleRequest($request);

        $engineModels = $this->repository
            ->findPaginated($form->getData()['filters'] ?? [], $form->getData()['order'] ?? [])
            ->setMaxPerPage(12)
            ->setCurrentPage(max($request->query->getInt('page', 1), 1));

        return $this->render('database/engine_model/list.html.twig', [
            'engineModels' => $engineModels,
            'form' => $form->createView(),
        ]);
    }

    #[Route(path: '/database/engine-models/{slug}', name: 'database_engine_model_read')]
    public function read(Request $request): Response
    {
        $slug = $request->attributes->get('slug');

        if (is_null($engineModel = $this->repository->findOneBy(['slug' => $slug]))) {
            throw new NotFoundHttpException();
        }

        $this->breadcrumbs->addItem('Index', $this->generateUrl('index'));
        $this->breadcrumbs->addItem('Engine models', $this->generateUrl('database_engine_model_list'));
        $this->breadcrumbs->addItem(
            (string)$engineModel->getName(),
            $this->generateUrl('database_engine_model_read', ['slug' => $engineModel->getSlug()])
        );

        $aircraftModels = $engineModel
            ->getAircraftModelsPaginated()
            ->setMaxPerPage(4)
            ->setCurrentPage(max($request->query->getInt('aircraftModelsPage', 1), 1));

        $aircraftTypes = $engineModel
            ->getAircraftTypesPaginated()
            ->setMaxPerPage(4)
            ->setCurrentPage(max($request->query->getInt('aircraftTypesPage', 1), 1));

        return $this->render('database/engine_model/read.html.twig', [
            'aircraftModels' => $aircraftModels,
            'aircraftTypes' => $aircraftTypes,
            'engineModel' => $engineModel,
        ]);
    }
}
