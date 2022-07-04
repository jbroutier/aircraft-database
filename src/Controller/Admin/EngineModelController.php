<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\EngineModel;
use App\Form\ConfirmType;
use App\Form\EngineModelFiltersType;
use App\Form\EngineModelType;
use App\Repository\EngineModelRepository;
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

class EngineModelController extends AbstractController
{
    public function __construct(
        protected readonly EngineModelRepository $repository,
        protected readonly FilterBuilderUpdaterInterface $builderUpdater,
        protected readonly TranslatorInterface $translator
    ) {
    }

    #[Route(path: '/admin/engine-models/{id}/clone', name: 'admin_engine_model_clone')]
    public function clone(Request $request): Response
    {
        $id = $request->attributes->get('id');

        if (is_null($engineModel = $this->repository->findOneBy(['id' => $id]))) {
            throw new NotFoundHttpException();
        }

        $form = $this->createForm(EngineModelType::class, clone $engineModel);

        return $this->render('admin/engine_model/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route(path: '/admin/engine-models/create', name: 'admin_engine_model_create')]
    public function create(Request $request): Response
    {
        $form = $this
            ->createForm(EngineModelType::class)
            ->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var EngineModel $engineModel */
            $engineModel = $form->getData();
            $this->repository->add($engineModel, true);
            $this->addFlash('success', $this->translator->trans('The engine model has been created.'));
            $default = $this->generateUrl('admin_engine_model_list', [], UrlGeneratorInterface::ABSOLUTE_URL);

            return $this->redirect($request->headers->get('Referer', $default));
        }

        return $this->render('admin/engine_model/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route(path: '/admin/engine-models/{id}/delete', name: 'admin_engine_model_delete')]
    public function delete(Request $request): Response
    {
        $id = $request->attributes->get('id');

        if (is_null($engineModel = $this->repository->findOneBy(['id' => $id]))) {
            throw new NotFoundHttpException();
        }

        $form = $this
            ->createForm(ConfirmType::class)
            ->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->repository->remove($engineModel, true);
            $this->addFlash('success', $this->translator->trans('The engine model has been deleted.'));
            $default = $this->generateUrl('admin_engine_model_list', [], UrlGeneratorInterface::ABSOLUTE_URL);

            return $this->redirect($request->headers->get('Referer', $default));
        }

        return $this->render('admin/engine_model/delete.html.twig', [
            'engineModel' => $engineModel,
            'form' => $form->createView(),
        ]);
    }

    #[Route(path: '/admin/engine-models', name: 'admin_engine_model_list')]
    public function list(Request $request): Response
    {
        $form = $this
            ->createForm(EngineModelFiltersType::class, null, ['method' => 'GET'])
            ->handleRequest($request);

        $builder = $this->repository->createQueryBuilder('em');
        $this->builderUpdater->addFilterConditions($form, $builder);
        $builder->addOrderBy('em.name', 'ASC');

        $engineModels = (new Pagerfanta(new QueryAdapter($builder)))
            ->setMaxPerPage(10)
            ->setCurrentPage(max($request->query->getInt('page', 1), 1));

        return $this->render('admin/engine_model/list.html.twig', [
            'engineModels' => $engineModels,
            'form' => $form->createView(),
        ]);
    }

    #[Route(path: '/admin/engine-models/{id}/update', name: 'admin_engine_model_update')]
    public function update(Request $request): Response
    {
        $id = $request->attributes->get('id');

        if (is_null($engineModel = $this->repository->findOneBy(['id' => $id]))) {
            throw new NotFoundHttpException();
        }

        $form = $this
            ->createForm(EngineModelType::class, $engineModel)
            ->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->repository->add($engineModel, true);
            $this->addFlash('success', $this->translator->trans('The engine model has been updated.'));
            $default = $this->generateUrl('admin_engine_model_list', [], UrlGeneratorInterface::ABSOLUTE_URL);

            return $this->redirect($request->headers->get('Referer', $default));
        }

        return $this->render('admin/engine_model/update.html.twig', [
            'engineModel' => $engineModel,
            'form' => $form->createView(),
        ]);
    }
}
