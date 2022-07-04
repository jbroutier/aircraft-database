<?php

declare(strict_types=1);

namespace App\Controller\Database;

use App\Form\ManufacturerFiltersType;
use App\Repository\ManufacturerRepository;
use Lexik\Bundle\FormFilterBundle\Filter\FilterBuilderUpdaterInterface;
use Pagerfanta\Doctrine\ORM\QueryAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use WhiteOctober\BreadcrumbsBundle\Model\Breadcrumbs;

class ManufacturerController extends AbstractController
{
    public function __construct(
        protected readonly Breadcrumbs $breadcrumbs,
        protected readonly FilterBuilderUpdaterInterface $builderUpdater,
        protected readonly ManufacturerRepository $repository
    ) {
    }

    #[Route(path: '/database/manufacturers', name: 'database_manufacturer_list')]
    public function list(Request $request): Response
    {
        $this->breadcrumbs->addItem('Home', $this->generateUrl('home'));
        $this->breadcrumbs->addItem('Manufacturers', $this->generateUrl('database_manufacturer_list'));

        $form = $this
            ->createForm(ManufacturerFiltersType::class, null, ['method' => 'GET'])
            ->handleRequest($request);

        $builder = $this->repository->createQueryBuilder('m');
        $this->builderUpdater->addFilterConditions($form, $builder);
        $builder->addOrderBy('m.name', 'ASC');

        $manufacturers = (new Pagerfanta(new QueryAdapter($builder)))
            ->setMaxPerPage(24)
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

        $this->breadcrumbs->addItem('Home', $this->generateUrl('home'));
        $this->breadcrumbs->addItem('Manufacturers', $this->generateUrl('database_manufacturer_list'));
        $this->breadcrumbs->addItem(
            (string)$manufacturer->getName(),
            $this->generateUrl('database_manufacturer_read', ['slug' => $manufacturer->getSlug()])
        );

        return $this->render('database/manufacturer/read.html.twig', [
            'manufacturer' => $manufacturer,
        ]);
    }
}
