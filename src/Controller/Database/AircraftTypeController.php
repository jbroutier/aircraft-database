<?php

declare(strict_types=1);

namespace App\Controller\Database;

use App\Enum\AircraftFamily;
use App\Enum\EngineFamily;
use App\Form\AircraftTypeFiltersType;
use App\Repository\AircraftTypeRepository;
use Lexik\Bundle\FormFilterBundle\Filter\FilterBuilderUpdaterInterface;
use Pagerfanta\Doctrine\ORM\QueryAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use WhiteOctober\BreadcrumbsBundle\Model\Breadcrumbs;

class AircraftTypeController extends AbstractController
{
    public function __construct(
        protected readonly AircraftTypeRepository $repository,
        protected readonly Breadcrumbs $breadcrumbs,
        protected readonly FilterBuilderUpdaterInterface $builderUpdater
    ) {
    }

    #[Route(path: '/database/aircraft-types', name: 'database_aircraft_type_list')]
    public function list(Request $request): Response
    {
        $this->breadcrumbs->addItem('Home', $this->generateUrl('home'));
        $this->breadcrumbs->addItem('Aircraft types', $this->generateUrl('database_aircraft_type_list'));

        $form = $this
            ->createForm(AircraftTypeFiltersType::class, null, ['method' => 'GET'])
            ->handleRequest($request);

        if (($aircraftFamily = $form->get('aircraftFamily')->getData()) instanceof AircraftFamily) {
            $this->breadcrumbs->addItem(
                $aircraftFamily->label(),
                $this->generateUrl('database_aircraft_type_list', ['filters[aircraftFamily]' => $aircraftFamily->value])
            );
        }

        if (($engineFamily = $form->get('engineFamily')->getData()) instanceof EngineFamily) {
            $this->breadcrumbs->addItem(
                $engineFamily->label(),
                $this->generateUrl('database_aircraft_type_list', ['filters[engineFamily]' => $engineFamily->value])
            );
        }

        $builder = $this->repository->createQueryBuilder('at');
        $this->builderUpdater->addFilterConditions($form, $builder);
        $builder->addOrderBy('at.name', 'ASC');

        $aircraftTypes = (new Pagerfanta(new QueryAdapter($builder)))
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

        $this->breadcrumbs->addItem('Home', $this->generateUrl('home'));
        $this->breadcrumbs->addItem('Aircraft types', $this->generateUrl('database_aircraft_type_list'));
        $this->breadcrumbs->addItem(
            $aircraftType->getManufacturer()?->getName() . ' ' . $aircraftType->getName(),
            $this->generateUrl('database_aircraft_type_read', ['slug' => $aircraftType->getSlug()])
        );

        return $this->render('database/aircraft_type/read.html.twig', [
            'aircraftType' => $aircraftType,
        ]);
    }
}
