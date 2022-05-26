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
        protected readonly Breadcrumbs $breadcrumbs,
        protected readonly EntityManagerInterface $entityManager
    ) {
    }

    #[Route(path: '/search', name: 'search')]
    public function __invoke(Request $request): Response
    {
        $this->breadcrumbs->addItem('Index', $this->generateUrl('index'));
        $this->breadcrumbs->addItem('Search', $this->generateUrl('search'));

        $form = $this->createForm(QueryType::class, null, ['method' => 'get']);
        $form->handleRequest($request);

        if (is_null($form->getData())) {
            return $this->redirectToRoute('index');
        }

        $manufacturersBuilder = $this->entityManager
            ->getRepository(Manufacturer::class)
            ->createQueryBuilder('m');

        $manufacturersBuilder
            ->select('m, MATCH_AGAINST (m.content, m.name) AGAINST (:query) AS score')
            ->where('MATCH_AGAINST (m.content, m.name) AGAINST (:query BOOLEAN) > 0')
            ->addOrderBy('score', 'DESC')
            ->addOrderBy('m.name', 'ASC')
            ->setParameter(':query', '"+' . $form->getData()['query'] . '"');

        $aircraftTypesBuilder = $this->entityManager
            ->getRepository(AircraftType::class)
            ->createQueryBuilder('at');

        $aircraftTypesBuilder
            ->select('at, MATCH_AGAINST (at.content, at.name) AGAINST (:query) AS score')
            ->where('MATCH_AGAINST (at.content, at.name) AGAINST (:query BOOLEAN) > 0')
            ->addOrderBy('score', 'DESC')
            ->addOrderBy('at.name', 'ASC')
            ->setParameter(':query', '"+' . $form->getData()['query'] . '"');

        $aircraftModelsBuilder = $this->entityManager
            ->getRepository(AircraftModel::class)
            ->createQueryBuilder('am');

        $aircraftModelsBuilder
            ->select('am, MATCH_AGAINST (am.content, am.name) AGAINST (:query) AS score')
            ->where('MATCH_AGAINST (am.content, am.name) AGAINST (:query BOOLEAN) > 0')
            ->addOrderBy('score', 'DESC')
            ->addOrderBy('am.name', 'ASC')
            ->setParameter(':query', '"+' . $form->getData()['query'] . '"');

        $engineModelsBuilder = $this->entityManager
            ->getRepository(EngineModel::class)
            ->createQueryBuilder('em');

        $engineModelsBuilder
            ->select('em, MATCH_AGAINST (em.content, em.name) AGAINST (:query) AS score')
            ->where('MATCH_AGAINST (em.content, em.name) AGAINST (:query BOOLEAN) > 0')
            ->addOrderBy('score', 'DESC')
            ->addOrderBy('em.name', 'ASC')
            ->setParameter(':query', '"+' . $form->getData()['query'] . '"');

        $adapter = new ConcatenationAdapter([
            new QueryAdapter($engineModelsBuilder),
            new QueryAdapter($aircraftModelsBuilder),
            new QueryAdapter($aircraftTypesBuilder),
            new QueryAdapter($manufacturersBuilder),
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
