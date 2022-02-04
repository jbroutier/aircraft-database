<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Form\ConfirmType;
use App\Form\PropertyGroupQueryType;
use App\Form\PropertyGroupType;
use App\Repository\PropertyGroupRepository;
use Doctrine\ORM\EntityManagerInterface;
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
        protected EntityManagerInterface $entityManager,
        protected PropertyGroupRepository $repository,
        protected TranslatorInterface $translator
    ) {
    }

    #[Route(path: '/admin/property-groups/{id}/clone', name: 'admin_property_group_clone')]
    public function clone(Request $request): Response
    {
        $id = $request->attributes->get('id');

        if (is_null($propertyGroup = $this->repository->findOneBy(['id' => $id]))) {
            throw new NotFoundHttpException();
        }

        $propertyGroup = clone $propertyGroup;

        $form = $this->createForm(PropertyGroupType::class, $propertyGroup);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($form->getData());
            $this->entityManager->flush();

            $this->addFlash('success', $this->translator->trans('Property group created.'));
            $default = $this->generateUrl('admin_property_group_list', [], UrlGeneratorInterface::ABSOLUTE_URL);

            return $this->redirect($request->headers->get('Referer', $default));
        }

        return $this->render('admin/property_group/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route(path: '/admin/property-groups/create', name: 'admin_property_group_create')]
    public function create(Request $request): Response
    {
        $form = $this->createForm(PropertyGroupType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($form->getData());
            $this->entityManager->flush();

            $this->addFlash('success', $this->translator->trans('Property group created.'));
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

        $form = $this->createForm(ConfirmType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->remove($propertyGroup);
            $this->entityManager->flush();

            $this->addFlash('success', $this->translator->trans('Property group deleted.'));
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
        $form = $this->createForm(PropertyGroupQueryType::class, null, ['method' => 'GET']);
        $form->handleRequest($request);

        $propertyGroups = $this->repository
            ->findPaginated($form->getData()['filters'] ?? [], $form->getData()['order'] ?? ['name' => 'ASC'])
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

        $form = $this->createForm(PropertyGroupType::class, $propertyGroup);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($propertyGroup);
            $this->entityManager->flush();

            $this->addFlash('success', $this->translator->trans('Property group updated.'));
            $default = $this->generateUrl('admin_property_group_list', [], UrlGeneratorInterface::ABSOLUTE_URL);

            return $this->redirect($request->headers->get('Referer', $default));
        }

        return $this->render('admin/property_group/update.html.twig', [
            'form' => $form->createView(),
            'propertyGroup' => $propertyGroup,
        ]);
    }
}
