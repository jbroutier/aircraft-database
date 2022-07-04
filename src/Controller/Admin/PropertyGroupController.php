<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\PropertyGroup;
use App\Form\ConfirmType;
use App\Form\PropertyGroupFiltersType;
use App\Form\PropertyGroupType;
use App\Repository\PropertyGroupRepository;
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

class PropertyGroupController extends AbstractController
{
    public function __construct(
        protected readonly FilterBuilderUpdaterInterface $builderUpdater,
        protected readonly PropertyGroupRepository $repository,
        protected readonly TranslatorInterface $translator
    ) {
    }

    #[Route(path: '/admin/property-groups/{id}/clone', name: 'admin_property_group_clone')]
    public function clone(Request $request): Response
    {
        $id = $request->attributes->get('id');

        if (is_null($propertyGroup = $this->repository->findOneBy(['id' => $id]))) {
            throw new NotFoundHttpException();
        }

        $form = $this->createForm(PropertyGroupType::class, clone $propertyGroup);

        return $this->render('admin/property_group/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route(path: '/admin/property-groups/create', name: 'admin_property_group_create')]
    public function create(Request $request): Response
    {
        $form = $this
            ->createForm(PropertyGroupType::class)
            ->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var PropertyGroup $propertyGroup */
            $propertyGroup = $form->getData();
            $this->repository->add($propertyGroup, true);
            $this->addFlash('success', $this->translator->trans('The property group has been created.'));
            $default = $this->generateUrl('admin_property_group_list', [], UrlGeneratorInterface::ABSOLUTE_URL);

            return $this->redirect($request->headers->get('Referer', $default));
        }

        return $this->render('admin/property_group/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route(path: '/admin/property-groups/{id}/delete', name: 'admin_property_group_delete')]
    public function delete(Request $request): Response
    {
        $id = $request->attributes->get('id');

        if (is_null($propertyGroup = $this->repository->findOneBy(['id' => $id]))) {
            throw new NotFoundHttpException();
        }

        $form = $this
            ->createForm(ConfirmType::class)
            ->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->repository->remove($propertyGroup, true);
            $this->addFlash('success', $this->translator->trans('The property group has been deleted.'));
            $default = $this->generateUrl('admin_property_group_list', [], UrlGeneratorInterface::ABSOLUTE_URL);

            return $this->redirect($request->headers->get('Referer', $default));
        }

        return $this->render('admin/property_group/delete.html.twig', [
            'form' => $form->createView(),
            'propertyGroup' => $propertyGroup,
        ]);
    }

    #[Route(path: '/admin/property-groups', name: 'admin_property_group_list')]
    public function list(Request $request): Response
    {
        $form = $this
            ->createForm(PropertyGroupFiltersType::class, null, ['method' => 'GET'])
            ->handleRequest($request);

        $builder = $this->repository->createQueryBuilder('pg');
        $this->builderUpdater->addFilterConditions($form, $builder);
        $builder->addOrderBy('pg.name', 'ASC');

        $propertyGroups = (new Pagerfanta(new QueryAdapter($builder)))
            ->setMaxPerPage(10)
            ->setCurrentPage(max($request->query->getInt('page', 1), 1));

        return $this->render('admin/property_group/list.html.twig', [
            'form' => $form->createView(),
            'propertyGroups' => $propertyGroups,
        ]);
    }

    #[Route(path: '/admin/property-groups/{id}/update', name: 'admin_property_group_update')]
    public function update(Request $request): Response
    {
        $id = $request->attributes->get('id');

        if (is_null($propertyGroup = $this->repository->findOneBy(['id' => $id]))) {
            throw new NotFoundHttpException();
        }

        $form = $this
            ->createForm(PropertyGroupType::class, $propertyGroup)
            ->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->repository->add($propertyGroup, true);
            $this->addFlash('success', $this->translator->trans('The property group has been updated.'));
            $default = $this->generateUrl('admin_property_group_list', [], UrlGeneratorInterface::ABSOLUTE_URL);

            return $this->redirect($request->headers->get('Referer', $default));
        }

        return $this->render('admin/property_group/update.html.twig', [
            'form' => $form->createView(),
            'propertyGroup' => $propertyGroup,
        ]);
    }
}
