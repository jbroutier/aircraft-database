<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\Property;
use App\Form\ConfirmType;
use App\Form\PropertyFiltersType;
use App\Form\PropertyType;
use App\Repository\PropertyRepository;
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

class PropertyController extends AbstractController
{
    public function __construct(
        protected readonly FilterBuilderUpdaterInterface $builderUpdater,
        protected readonly PropertyRepository $repository,
        protected readonly TranslatorInterface $translator
    ) {
    }

    #[Route(path: '/admin/properties/{id}/clone', name: 'admin_property_clone')]
    public function clone(Request $request): Response
    {
        $id = $request->attributes->get('id');

        if (is_null($property = $this->repository->findOneBy(['id' => $id]))) {
            throw new NotFoundHttpException();
        }

        $form = $this->createForm(PropertyType::class, clone $property);

        return $this->render('admin/property/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route(path: '/admin/properties/create', name: 'admin_property_create')]
    public function create(Request $request): Response
    {
        $form = $this
            ->createForm(PropertyType::class)
            ->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Property $property */
            $property = $form->getData();
            $this->repository->add($property, true);
            $this->addFlash('success', $this->translator->trans('The property has been created.'));
            $default = $this->generateUrl('admin_property_list', [], UrlGeneratorInterface::ABSOLUTE_URL);

            return $this->redirect($request->headers->get('Referer', $default));
        }

        return $this->render('admin/property/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route(path: '/admin/properties/{id}/delete', name: 'admin_property_delete')]
    public function delete(Request $request): Response
    {
        $id = $request->attributes->get('id');

        if (is_null($property = $this->repository->findOneBy(['id' => $id]))) {
            throw new NotFoundHttpException();
        }

        $form = $this
            ->createForm(ConfirmType::class)
            ->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->repository->remove($property, true);
            $this->addFlash('success', $this->translator->trans('The property has been deleted.'));
            $default = $this->generateUrl('admin_property_list', [], UrlGeneratorInterface::ABSOLUTE_URL);

            return $this->redirect($request->headers->get('Referer', $default));
        }

        return $this->render('admin/property/delete.html.twig', [
            'form' => $form->createView(),
            'property' => $property,
        ]);
    }

    #[Route(path: '/admin/properties', name: 'admin_property_list')]
    public function list(Request $request): Response
    {
        $form = $this
            ->createForm(PropertyFiltersType::class, null, ['method' => 'GET'])
            ->handleRequest($request);

        $builder = $this->repository->createQueryBuilder('p');
        $this->builderUpdater->addFilterConditions($form, $builder);
        $builder->addOrderBy('p.name', 'ASC');

        $properties = (new Pagerfanta(new QueryAdapter($builder)))
            ->setMaxPerPage(10)
            ->setCurrentPage(max($request->query->getInt('page', 1), 1));

        return $this->render('admin/property/list.html.twig', [
            'form' => $form->createView(),
            'properties' => $properties,
        ]);
    }

    #[Route(path: '/admin/properties/{id}/update', name: 'admin_property_update')]
    public function update(Request $request): Response
    {
        $id = $request->attributes->get('id');

        if (is_null($property = $this->repository->findOneBy(['id' => $id]))) {
            throw new NotFoundHttpException();
        }

        $form = $this
            ->createForm(PropertyType::class, $property)
            ->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->repository->add($property, true);
            $this->addFlash('success', $this->translator->trans('The property has been updated.'));
            $default = $this->generateUrl('admin_property_list', [], UrlGeneratorInterface::ABSOLUTE_URL);

            return $this->redirect($request->headers->get('Referer', $default));
        }

        return $this->render('admin/property/update.html.twig', [
            'form' => $form->createView(),
            'property' => $property,
        ]);
    }
}
