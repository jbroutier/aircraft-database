<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\Tag;
use App\Form\ConfirmType;
use App\Form\TagFiltersType;
use App\Form\TagType;
use App\Repository\TagRepository;
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

class TagController extends AbstractController
{
    public function __construct(
        protected readonly FilterBuilderUpdaterInterface $builderUpdater,
        protected readonly TagRepository $repository,
        protected readonly TranslatorInterface $translator
    ) {
    }

    #[Route(path: '/admin/tags/{id}/clone', name: 'admin_tag_clone')]
    public function clone(Request $request): Response
    {
        $id = $request->attributes->get('id');

        if (is_null($tag = $this->repository->findOneBy(['id' => $id]))) {
            throw new NotFoundHttpException();
        }

        $form = $this->createForm(TagType::class, clone $tag);

        return $this->render('admin/tag/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route(path: '/admin/tags/create', name: 'admin_tag_create')]
    public function create(Request $request): Response
    {
        $form = $this
            ->createForm(TagType::class)
            ->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Tag $tag */
            $tag = $form->getData();
            $this->repository->add($tag, true);
            $this->addFlash('success', $this->translator->trans('The tag has been created.'));
            $default = $this->generateUrl('admin_tag_list', [], UrlGeneratorInterface::ABSOLUTE_URL);

            return $this->redirect($request->headers->get('Referer', $default));
        }

        return $this->render('admin/tag/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route(path: '/admin/tags/{id}/delete', name: 'admin_tag_delete')]
    public function delete(Request $request): Response
    {
        $id = $request->attributes->get('id');

        if (is_null($tag = $this->repository->findOneBy(['id' => $id]))) {
            throw new NotFoundHttpException();
        }

        $form = $this
            ->createForm(ConfirmType::class)
            ->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->repository->remove($tag, true);
            $this->addFlash('success', $this->translator->trans('The tag has been deleted.'));
            $default = $this->generateUrl('admin_tag_list', [], UrlGeneratorInterface::ABSOLUTE_URL);

            return $this->redirect($request->headers->get('Referer', $default));
        }

        return $this->render('admin/tag/delete.html.twig', [
            'form' => $form->createView(),
            'tag' => $tag,
        ]);
    }

    #[Route(path: '/admin/tags', name: 'admin_tag_list')]
    public function list(Request $request): Response
    {
        $form = $this
            ->createForm(TagFiltersType::class, null, ['method' => 'GET'])
            ->handleRequest($request);

        $builder = $this->repository->createQueryBuilder('t');
        $this->builderUpdater->addFilterConditions($form, $builder);
        $builder->addOrderBy('t.name', 'ASC');

        $tags = (new Pagerfanta(new QueryAdapter($builder)))
            ->setMaxPerPage(10)
            ->setCurrentPage(max($request->query->getInt('page', 1), 1));

        return $this->render('admin/tag/list.html.twig', [
            'form' => $form->createView(),
            'tags' => $tags,
        ]);
    }

    #[Route(path: '/admin/tags/{id}/update', name: 'admin_tag_update')]
    public function update(Request $request): Response
    {
        $id = $request->attributes->get('id');

        if (is_null($tag = $this->repository->findOneBy(['id' => $id]))) {
            throw new NotFoundHttpException();
        }

        $form = $this
            ->createForm(TagType::class, $tag)
            ->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->repository->add($tag, true);
            $this->addFlash('success', $this->translator->trans('The tag has been updated.'));
            $default = $this->generateUrl('admin_tag_list', [], UrlGeneratorInterface::ABSOLUTE_URL);

            return $this->redirect($request->headers->get('Referer', $default));
        }

        return $this->render('admin/tag/update.html.twig', [
            'form' => $form->createView(),
            'tag' => $tag,
        ]);
    }
}
