<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\AircraftModel;
use App\Form\AircraftModelFiltersType;
use App\Form\AircraftModelType;
use App\Form\ConfirmType;
use App\Repository\AircraftModelRepository;
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

class AircraftModelController extends AbstractController
{
    public function __construct(
        protected readonly AircraftModelRepository $repository,
        protected readonly FilterBuilderUpdaterInterface $builderUpdater,
        protected readonly TranslatorInterface $translator
    ) {
    }

    #[Route(path: '/admin/aircraft-models/{id}/autofill', name: 'admin_aircraft_model_autofill')]
    public function autofill(Request $request): Response
    {
        $id = $request->attributes->get('id');

        if (is_null($aircraftModel = $this->repository->findOneBy(['id' => $id]))) {
            throw new NotFoundHttpException();
        }

        if (!is_null($aircraftType = $aircraftModel->getAircraftType())) {
            if ($aircraftModel->getEngineModels()->isEmpty()) {
                $aircraftModel->setEngineModels($aircraftType->getEngineModels()->toArray());
            }

            foreach ($aircraftType->getPropertyValues() as $propertyValue) {
                if (!is_null($propertyValue->getProperty()) &&
                    !$aircraftModel->getProperties()->contains($propertyValue->getProperty())) {
                    $aircraftModel->addPropertyValue(clone $propertyValue);
                }
            }
        }

        $form = $this
            ->createForm(AircraftModelType::class, $aircraftModel)
            ->handleRequest($request);

        return $this->render('admin/aircraft_model/update.html.twig', [
            'aircraftModel' => $aircraftModel,
            'form' => $form->createView(),
        ]);
    }

    #[Route(path: '/admin/aircraft-models/{id}/clone', name: 'admin_aircraft_model_clone')]
    public function clone(Request $request): Response
    {
        $id = $request->attributes->get('id');

        if (is_null($aircraftModel = $this->repository->findOneBy(['id' => $id]))) {
            throw new NotFoundHttpException();
        }

        $form = $this->createForm(AircraftModelType::class, clone $aircraftModel);

        return $this->render('admin/aircraft_model/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route(path: '/admin/aircraft-models/create', name: 'admin_aircraft_model_create')]
    public function create(Request $request): Response
    {
        $form = $this
            ->createForm(AircraftModelType::class)
            ->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var AircraftModel $aircraftModel */
            $aircraftModel = $form->getData();
            $this->repository->add($aircraftModel, true);
            $this->addFlash('success', $this->translator->trans('The aircraft model has been created.'));
            $default = $this->generateUrl('admin_aircraft_model_list', [], UrlGeneratorInterface::ABSOLUTE_URL);

            return $this->redirect($request->headers->get('Referer', $default));
        }

        return $this->render('admin/aircraft_model/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route(path: '/admin/aircraft-models/{id}/delete', name: 'admin_aircraft_model_delete')]
    public function delete(Request $request): Response
    {
        $id = $request->attributes->get('id');

        if (is_null($aircraftModel = $this->repository->findOneBy(['id' => $id]))) {
            throw new NotFoundHttpException();
        }

        $form = $this
            ->createForm(ConfirmType::class)
            ->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->repository->remove($aircraftModel, true);
            $this->addFlash('success', $this->translator->trans('The aircraft model has been deleted.'));
            $default = $this->generateUrl('admin_aircraft_model_list', [], UrlGeneratorInterface::ABSOLUTE_URL);

            return $this->redirect($request->headers->get('Referer', $default));
        }

        return $this->render('admin/aircraft_model/delete.html.twig', [
            'aircraftModel' => $aircraftModel,
            'form' => $form->createView(),
        ]);
    }

    #[Route(path: '/admin/aircraft-models', name: 'admin_aircraft_model_list')]
    public function list(Request $request): Response
    {
        $form = $this
            ->createForm(AircraftModelFiltersType::class, null, ['method' => 'GET'])
            ->handleRequest($request);

        $builder = $this->repository->createQueryBuilder('am');
        $this->builderUpdater->addFilterConditions($form, $builder);
        $builder->addOrderBy('am.name', 'ASC');

        $aircraftModels = (new Pagerfanta(new QueryAdapter($builder)))
            ->setMaxPerPage(10)
            ->setCurrentPage(max($request->query->getInt('page', 1), 1));

        return $this->render('admin/aircraft_model/list.html.twig', [
            'aircraftModels' => $aircraftModels,
            'form' => $form->createView(),
        ]);
    }

    #[Route(path: '/admin/aircraft-models/{id}/update', name: 'admin_aircraft_model_update')]
    public function update(Request $request): Response
    {
        $id = $request->attributes->get('id');

        if (is_null($aircraftModel = $this->repository->findOneBy(['id' => $id]))) {
            throw new NotFoundHttpException();
        }

        $form = $this
            ->createForm(AircraftModelType::class, $aircraftModel)
            ->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->repository->add($aircraftModel, true);
            $this->addFlash('success', $this->translator->trans('The aircraft model has been updated.'));
            $default = $this->generateUrl('admin_aircraft_model_list', [], UrlGeneratorInterface::ABSOLUTE_URL);

            return $this->redirect($request->headers->get('Referer', $default));
        }

        return $this->render('admin/aircraft_model/update.html.twig', [
            'aircraftModel' => $aircraftModel,
            'form' => $form->createView(),
        ]);
    }
}
