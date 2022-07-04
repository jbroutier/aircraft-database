<?php

declare(strict_types=1);

namespace App\Controller\Database;

use App\Enum\EngineFamily;
use App\Form\EngineModelFiltersType;
use App\Repository\EngineModelRepository;
use Lexik\Bundle\FormFilterBundle\Filter\FilterBuilderUpdaterInterface;
use Pagerfanta\Doctrine\ORM\QueryAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use WhiteOctober\BreadcrumbsBundle\Model\Breadcrumbs;

class EngineModelController extends AbstractController
{
    public function __construct(
        protected readonly Breadcrumbs $breadcrumbs,
        protected readonly EngineModelRepository $repository,
        protected readonly FilterBuilderUpdaterInterface $builderUpdater
    ) {
    }

    #[Route(path: '/database/engine-models', name: 'database_engine_model_list')]
    public function list(Request $request): Response
    {
        $this->breadcrumbs->addItem('Home', $this->generateUrl('home'));
        $this->breadcrumbs->addItem('Engine models', $this->generateUrl('database_engine_model_list'));

        $form = $this
            ->createForm(EngineModelFiltersType::class, null, ['method' => 'GET'])
            ->handleRequest($request);

        if (($engineFamily = $form->get('engineFamily')->getData()) instanceof EngineFamily) {
            $this->breadcrumbs->addItem(
                $engineFamily->label(),
                $this->generateUrl('database_aircraft_type_list', ['filters[engineFamily]' => $engineFamily->value])
            );
        }

        $builder = $this->repository->createQueryBuilder('em');
        $this->builderUpdater->addFilterConditions($form, $builder);
        $builder->addOrderBy('em.name', 'ASC');

        $engineModels = (new Pagerfanta(new QueryAdapter($builder)))
            ->setMaxPerPage(24)
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

        $this->breadcrumbs->addItem('Home', $this->generateUrl('home'));
        $this->breadcrumbs->addItem('Engine models', $this->generateUrl('database_engine_model_list'));
        $this->breadcrumbs->addItem(
            $engineModel->getManufacturer()?->getName() . ' ' . $engineModel->getName(),
            $this->generateUrl('database_engine_model_read', ['slug' => $engineModel->getSlug()])
        );

        return $this->render('database/engine_model/read.html.twig', [
            'engineModel' => $engineModel,
        ]);
    }
}
