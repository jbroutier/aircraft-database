<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\AircraftModel;
use App\Entity\AircraftType;
use App\Entity\EngineModel;
use App\Entity\Manufacturer;
use App\Form\QueryType;
use Doctrine\ORM\EntityManagerInterface;
use Pagerfanta\Adapter\ConcatenationAdapter;
use Pagerfanta\Doctrine\ORM\QueryAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use WhiteOctober\BreadcrumbsBundle\Model\Breadcrumbs;

class SearchController extends AbstractController
{
    public function __construct(
        protected Breadcrumbs $breadcrumbs,
        protected EntityManagerInterface $entityManager
    ) {
    }

    #[Route(path: '/search', name: 'search')]
    public function __invoke(Request $request): Response
    {
        $this->breadcrumbs->addItem('Index', $this->generateUrl('index'));
        $this->breadcrumbs->addItem('Search', $this->generateUrl('search'));

        $form = $this->createForm(QueryType::class, null, ['method' => 'get']);
        $form->handleRequest($request);

        $manufacturersBuilder = $this->entityManager
            ->getRepository(Manufacturer::class)
            ->createQueryBuilder('m');

        $manufacturersBuilder
            ->where($manufacturersBuilder->expr()->like('m.name', ':query'))
            ->setParameter(':query', '%' . $form->getData()['query'] . '%');

        $aircraftTypesBuilder = $this->entityManager
            ->getRepository(AircraftType::class)
            ->createQueryBuilder('at');

        $aircraftTypesBuilder
            ->leftJoin('at.manufacturer', 'm')
            ->where($aircraftTypesBuilder->expr()->like('at.name', ':query'))
            ->orWhere($aircraftTypesBuilder->expr()->like('m.name', ':query'))
            ->setParameter(':query', '%' . $form->getData()['query'] . '%');

        $aircraftModelsBuilder = $this->entityManager
            ->getRepository(AircraftModel::class)
            ->createQueryBuilder('am');

        $aircraftModelsBuilder
            ->leftJoin('am.manufacturer', 'm')
            ->where($aircraftModelsBuilder->expr()->like('am.name', ':query'))
            ->orWhere($aircraftModelsBuilder->expr()->like('m.name', ':query'))
            ->setParameter(':query', '%' . $form->getData()['query'] . '%');

        $engineModelsBuilder = $this->entityManager
            ->getRepository(EngineModel::class)
            ->createQueryBuilder('em');

        $engineModelsBuilder
            ->leftJoin('em.manufacturer', 'm')
            ->where($aircraftModelsBuilder->expr()->like('em.name', ':query'))
            ->orWhere($aircraftTypesBuilder->expr()->like('m.name', ':query'))
            ->setParameter(':query', '%' . $form->getData()['query'] . '%');

        $adapter = new ConcatenationAdapter([
            new QueryAdapter($manufacturersBuilder),
            new QueryAdapter($aircraftTypesBuilder),
            new QueryAdapter($aircraftModelsBuilder),
            new QueryAdapter($engineModelsBuilder),
        ]);

        $results = new Pagerfanta($adapter);
        $results
            ->setMaxNbPages(10)
            ->setMaxPerPage(10)
            ->setCurrentPage(max($request->query->getInt('page', 1), 1));

        return $this->render('search.html.twig', [
            'form' => $form->createView(),
            'results' => $results,
        ]);
    }
}
