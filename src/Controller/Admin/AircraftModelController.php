<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Form\AircraftModelQueryType;
use App\Form\AircraftModelType;
use App\Form\ConfirmType;
use App\Repository\AircraftModelRepository;
use Doctrine\ORM\EntityManagerInterface;
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
        protected AircraftModelRepository $repository,
        protected EntityManagerInterface $entityManager,
        protected TranslatorInterface $translator
    ) {
    }

    #[Route(path: '/admin/aircraft-models/{id}/clone', name: 'admin_aircraft_model_clone')]
    public function clone(Request $request): Response
    {
        $id = $request->attributes->get('id');

        if (is_null($aircraftModel = $this->repository->findOneBy(['id' => $id]))) {
            throw new NotFoundHttpException();
        }

        $aircraftModel = clone $aircraftModel;

        $form = $this->createForm(AircraftModelType::class, $aircraftModel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($form->getData());
            $this->entityManager->flush();

            $this->addFlash('success', $this->translator->trans('Aircraft model created.'));
            $default = $this->generateUrl('admin_aircraft_model_list', [], UrlGeneratorInterface::ABSOLUTE_URL);

            return $this->redirect($request->headers->get('Referer', $default));
        }

        return $this->render('admin/aircraft_model/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route(path: '/admin/aircraft-models/create', name: 'admin_aircraft_model_create')]
    public function create(Request $request): Response
    {
        $form = $this->createForm(AircraftModelType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($form->getData());
            $this->entityManager->flush();

            $this->addFlash('success', $this->translator->trans('Aircraft model created.'));
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

        $form = $this->createForm(ConfirmType::class);
        $form->handleRequest($request);

        $form = $this->createForm(ConfirmType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->remove($aircraftModel);
            $this->entityManager->flush();

            $this->addFlash('success', $this->translator->trans('Aircraft model deleted.'));
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
        $form = $this->createForm(AircraftModelQueryType::class, null, ['method' => 'GET']);
        $form->handleRequest($request);

        $aircraftModels = $this->repository
            ->findPaginated($form->getData()['filters'] ?? [], $form->getData()['order'] ?? ['name' => 'ASC'])
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

        $form = $this->createForm(AircraftModelType::class, $aircraftModel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($aircraftModel);
            $this->entityManager->flush();

            $this->addFlash('success', $this->translator->trans('Aircraft model updated.'));
            $default = $this->generateUrl('admin_aircraft_model_list', [], UrlGeneratorInterface::ABSOLUTE_URL);

            return $this->redirect($request->headers->get('Referer', $default));
        }

        return $this->render('admin/aircraft_model/update.html.twig', [
            'aircraftModel' => $aircraftModel,
            'form' => $form->createView(),
        ]);
    }
}
