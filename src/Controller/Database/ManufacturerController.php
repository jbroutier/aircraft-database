<?php

declare(strict_types=1);

namespace App\Controller\Database;

use App\Form\ManufacturerQueryType;
use App\Repository\ManufacturerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use WhiteOctober\BreadcrumbsBundle\Model\Breadcrumbs;

class ManufacturerController extends AbstractController
{
    public function __construct(
        protected Breadcrumbs $breadcrumbs,
        protected ManufacturerRepository $repository
    ) {
    }

    #[Route(path: '/database/manufacturers', name: 'database_manufacturer_list')]
    public function list(Request $request): Response
    {
        $this->breadcrumbs->addItem('Index', $this->generateUrl('index'));
        $this->breadcrumbs->addItem('Manufacturers', $this->generateUrl('database_manufacturer_list'));

        $form = $this->createForm(ManufacturerQueryType::class, null, ['method' => 'GET']);
        $form->handleRequest($request);

        $manufacturers = $this->repository
            ->findPaginated($form->getData()['filters'] ?? [], $form->getData()['order'] ?? ['name' => 'ASC'])
            ->setMaxPerPage(12)
            ->setCurrentPage(max($request->query->getInt('page', 1), 1));

        return $this->render('database/manufacturer/list.html.twig', [
            'form' => $form->createView(),
            'manufacturers' => $manufacturers,
        ]);
    }

    #[Route(path: '/database/manufacturers/{slug}', name: 'database_manufacturer_read')]
    public function read(Request $request): Response
    {
        $slug = $request->attributes->get('slug');

        if (is_null($manufacturer = $this->repository->findOneBy(['slug' => $slug]))) {
            throw new NotFoundHttpException();
        }

        $this->breadcrumbs->addItem('Index', $this->generateUrl('index'));
        $this->breadcrumbs->addItem('Manufacturers', $this->generateUrl('database_manufacturer_list'));
        $this->breadcrumbs->addItem(
            (string)$manufacturer->getName(),
            $this->generateUrl('database_manufacturer_read', ['slug' => $manufacturer->getSlug()])
        );

        $aircraftModels = $manufacturer
            ->getAircraftModelsPaginated()
            ->setMaxPerPage(4)
            ->setCurrentPage(max($request->query->getInt('aircraftModelsPage', 1), 1));

        $aircraftTypes = $manufacturer
            ->getAircraftTypesPaginated()
            ->setMaxPerPage(4)
            ->setCurrentPage(max($request->query->getInt('aircraftTypesPage', 1), 1));

        $engineModels = $manufacturer
            ->getEngineModelsPaginated()
            ->setMaxPerPage(4)
            ->setCurrentPage(max($request->query->getInt('engineModelsPage', 1), 1));

        return $this->render('database/manufacturer/read.html.twig', [
            'aircraftModels' => $aircraftModels,
            'aircraftTypes' => $aircraftTypes,
            'engineModels' => $engineModels,
            'manufacturer' => $manufacturer,
        ]);
    }
}
