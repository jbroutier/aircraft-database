<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\Manufacturer;
use App\Form\ConfirmType;
use App\Form\ManufacturerFiltersType;
use App\Form\ManufacturerType;
use App\Repository\ManufacturerRepository;
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

class ManufacturerController extends AbstractController
{
    public function __construct(
        protected readonly FilterBuilderUpdaterInterface $builderUpdater,
        protected readonly ManufacturerRepository $repository,
        protected readonly TranslatorInterface $translator
    ) {
    }

    #[Route(path: '/admin/manufacturers/{id}/clone', name: 'admin_manufacturer_clone')]
    public function clone(Request $request): Response
    {
        $id = $request->attributes->get('id');

        if (is_null($manufacturer = $this->repository->findOneBy(['id' => $id]))) {
            throw new NotFoundHttpException();
        }

        $form = $this->createForm(ManufacturerType::class, clone $manufacturer);

        return $this->render('admin/manufacturer/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route(path: '/admin/manufacturers/create', name: 'admin_manufacturer_create')]
    public function create(Request $request): Response
    {
        $form = $this
            ->createForm(ManufacturerType::class)
            ->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Manufacturer $manufacturer */
            $manufacturer = $form->getData();
            $this->repository->add($manufacturer, true);
            $this->addFlash('success', $this->translator->trans('The manufacturer has been created.'));
            $default = $this->generateUrl('admin_manufacturer_list', [], UrlGeneratorInterface::ABSOLUTE_URL);

            return $this->redirect($request->headers->get('Referer', $default));
        }

        return $this->render('admin/manufacturer/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route(path: '/admin/manufacturers/{id}/delete', name: 'admin_manufacturer_delete')]
    public function delete(Request $request): Response
    {
        $id = $request->attributes->get('id');

        if (is_null($manufacturer = $this->repository->findOneBy(['id' => $id]))) {
            throw new NotFoundHttpException();
        }

        $form = $this
            ->createForm(ConfirmType::class)
            ->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->repository->remove($manufacturer, true);
            $this->addFlash('success', $this->translator->trans('The manufacturer has been deleted.'));
            $default = $this->generateUrl('admin_manufacturer_list', [], UrlGeneratorInterface::ABSOLUTE_URL);

            return $this->redirect($request->headers->get('Referer', $default));
        }

        return $this->render('admin/manufacturer/delete.html.twig', [
            'form' => $form->createView(),
            'manufacturer' => $manufacturer,
        ]);
    }

    #[Route(path: '/admin/manufacturers', name: 'admin_manufacturer_list')]
    public function list(Request $request): Response
    {
        $form = $this
            ->createForm(ManufacturerFiltersType::class, null, ['method' => 'GET'])
            ->handleRequest($request);

        $builder = $this->repository->createQueryBuilder('m');
        $this->builderUpdater->addFilterConditions($form, $builder);
        $builder->addOrderBy('m.name', 'ASC');

        $manufacturers = (new Pagerfanta(new QueryAdapter($builder)))
            ->setMaxPerPage(10)
            ->setCurrentPage(max($request->query->getInt('page', 1), 1));

        return $this->render('admin/manufacturer/list.html.twig', [
            'form' => $form->createView(),
            'manufacturers' => $manufacturers,
        ]);
    }

    #[Route(path: '/admin/manufacturers/{id}/update', name: 'admin_manufacturer_update')]
    public function update(Request $request): Response
    {
        $id = $request->attributes->get('id');

        if (is_null($manufacturer = $this->repository->findOneBy(['id' => $id]))) {
            throw new NotFoundHttpException();
        }

        $form = $this
            ->createForm(ManufacturerType::class, $manufacturer)
            ->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->repository->add($manufacturer, true);
            $this->addFlash('success', $this->translator->trans('The manufacturer has been updated.'));
            $default = $this->generateUrl('admin_manufacturer_list', [], UrlGeneratorInterface::ABSOLUTE_URL);

            return $this->redirect($request->headers->get('Referer', $default));
        }

        return $this->render('admin/manufacturer/update.html.twig', [
            'form' => $form->createView(),
            'manufacturer' => $manufacturer,
        ]);
    }
}
