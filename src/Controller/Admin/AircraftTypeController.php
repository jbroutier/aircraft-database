<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\AircraftType;
use App\Form\AircraftTypeFiltersType;
use App\Form\AircraftTypeType;
use App\Form\ConfirmType;
use App\Repository\AircraftTypeRepository;
use Lexik\Bundle\FormFilterBundle\Filter\FilterBuilderUpdaterInterface;
use Pagerfanta\Doctrine\ORM\QueryAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class AircraftTypeController extends AbstractController
{
    public function __construct(
        protected readonly AircraftTypeRepository $repository,
        protected readonly FilterBuilderUpdaterInterface $builderUpdater,
        protected readonly TranslatorInterface $translator
    ) {
    }

    #[Route(path: '/admin/aircraft-types/{id}/clone', name: 'admin_aircraft_type_clone')]
    public function clone(Request $request): Response
    {
        $id = $request->attributes->get('id');

        if (is_null($aircraftType = $this->repository->findOneBy(['id' => $id]))) {
            throw new NotFoundHttpException();
        }

        $form = $this->createForm(AircraftTypeType::class, clone $aircraftType);

        return $this->render('admin/aircraft_type/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route(path: '/admin/aircraft-types/create', name: 'admin_aircraft_type_create')]
    public function create(Request $request): Response
    {
        $form = $this
            ->createForm(AircraftTypeType::class)
            ->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var AircraftType $aircraftType */
            $aircraftType = $form->getData();
            $this->repository->add($aircraftType, true);
            $this->addFlash('success', $this->translator->trans('The aircraft type has been created.'));
            $default = $this->generateUrl('admin_aircraft_type_list', [], UrlGeneratorInterface::ABSOLUTE_URL);

            return $this->redirect($request->headers->get('Referer', $default));
        }

        return $this->render('admin/aircraft_type/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route(path: '/admin/aircraft-types/{id}/delete', name: 'admin_aircraft_type_delete')]
    public function delete(Request $request): Response
    {
        $id = $request->attributes->get('id');

        if (is_null($aircraftType = $this->repository->findOneBy(['id' => $id]))) {
            throw new NotFoundHttpException();
        }

        $form = $this
            ->createForm(ConfirmType::class)
            ->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->repository->remove($aircraftType, true);
            $this->addFlash('success', $this->translator->trans('The aircraft type has been deleted.'));
            $default = $this->generateUrl('admin_aircraft_type_list', [], UrlGeneratorInterface::ABSOLUTE_URL);

            return $this->redirect($request->headers->get('Referer', $default));
        }

        return $this->render('admin/aircraft_type/delete.html.twig', [
            'aircraftType' => $aircraftType,
            'form' => $form->createView(),
        ]);
    }

    #[Route(path: '/admin/aircraft-types', name: 'admin_aircraft_type_list')]
    public function list(Request $request): Response
    {
        $form = $this
            ->createForm(AircraftTypeFiltersType::class, null, ['method' => 'GET'])
            ->handleRequest($request);

        $builder = $this->repository->createQueryBuilder('at');
        $this->builderUpdater->addFilterConditions($form, $builder);
        $builder->addOrderBy('at.name', 'ASC');

        $aircraftTypes = (new Pagerfanta(new QueryAdapter($builder)))
            ->setMaxPerPage(10)
            ->setCurrentPage(max($request->query->getInt('page', 1), 1));

        return $this->render('admin/aircraft_type/list.html.twig', [
            'aircraftTypes' => $aircraftTypes,
            'form' => $form->createView(),
        ]);
    }

    #[Route(path: '/admin/aircraft-types/{id}/update', name: 'admin_aircraft_type_update')]
    public function update(Request $request): Response
    {
        $id = $request->attributes->get('id');

        if (is_null($aircraftType = $this->repository->findOneBy(['id' => $id]))) {
            throw new NotFoundHttpException();
        }

        $form = $this
            ->createForm(AircraftTypeType::class, $aircraftType)
            ->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->repository->add($aircraftType, true);
            $this->addFlash('success', $this->translator->trans('The aircraft type has been updated.'));
            $default = $this->generateUrl('admin_aircraft_type_list', [], UrlGeneratorInterface::ABSOLUTE_URL);

            return $this->redirect($request->headers->get('Referer', $default));
        }

        return $this->render('admin/aircraft_type/update.html.twig', [
            'aircraftType' => $aircraftType,
            'form' => $form->createView(),
        ]);
    }
}
