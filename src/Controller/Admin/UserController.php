<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Form\ConfirmType;
use App\Form\UserFiltersType;
use App\Repository\UserRepository;
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

class UserController extends AbstractController
{
    public function __construct(
        protected readonly FilterBuilderUpdaterInterface $builderUpdater,
        protected readonly TranslatorInterface $translator,
        protected readonly UserRepository $repository
    ) {
    }

    #[Route(path: '/admin/users/{id}/delete', name: 'admin_user_delete')]
    public function delete(Request $request): Response
    {
        $id = $request->attributes->get('id');

        if (is_null($user = $this->repository->findOneBy(['id' => $id]))) {
            throw new NotFoundHttpException();
        }

        $this->denyAccessUnlessGranted('DELETE_USER', $user);

        $form = $this
            ->createForm(ConfirmType::class)
            ->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->repository->remove($user, true);
            $this->addFlash('success', $this->translator->trans('The user has been deleted.'));
            $default = $this->generateUrl('admin_user_list', [], UrlGeneratorInterface::ABSOLUTE_URL);

            return $this->redirect($request->headers->get('Referer', $default));
        }

        return $this->render('admin/user/delete.html.twig', [
            'form' => $form->createView(),
            'user' => $user,
        ]);
    }

    #[Route(path: '/admin/users', name: 'admin_user_list')]
    public function list(Request $request): Response
    {
        $form = $this
            ->createForm(UserFiltersType::class, null, ['method' => 'GET'])
            ->handleRequest($request);

        $builder = $this->repository->createQueryBuilder('u');
        $this->builderUpdater->addFilterConditions($form, $builder);
        $builder
            ->addOrderBy('u.lastName', 'ASC')
            ->addOrderBy('u.firstName', 'ASC');

        $users = (new Pagerfanta(new QueryAdapter($builder)))
            ->setMaxPerPage(10)
            ->setCurrentPage(max($request->query->getInt('page', 1), 1));

        return $this->render('admin/user/list.html.twig', [
            'form' => $form->createView(),
            'users' => $users,
        ]);
    }

    #[Route(path: '/admin/users/{id}/lock', name: 'admin_user_lock')]
    public function lock(Request $request): Response
    {
        $id = $request->attributes->get('id');

        if (is_null($user = $this->repository->findOneBy(['id' => $id]))) {
            throw new NotFoundHttpException();
        }

        $this->denyAccessUnlessGranted('LOCK_USER', $user);

        $form = $this
            ->createForm(ConfirmType::class)
            ->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setLocked(true);
            $this->repository->add($user, true);
            $this->addFlash('success', $this->translator->trans('The user has been locked.'));
            $default = $this->generateUrl('admin_user_list', [], UrlGeneratorInterface::ABSOLUTE_URL);

            return $this->redirect($request->headers->get('Referer', $default));
        }

        return $this->render('admin/user/lock.html.twig', [
            'form' => $form->createView(),
            'user' => $user,
        ]);
    }

    #[Route(path: '/admin/users/{id}/unlock', name: 'admin_user_unlock')]
    public function unlock(Request $request): Response
    {
        $id = $request->attributes->get('id');

        if (is_null($user = $this->repository->findOneBy(['id' => $id]))) {
            throw new NotFoundHttpException();
        }

        $this->denyAccessUnlessGranted('UNLOCK_USER', $user);

        $form = $this
            ->createForm(ConfirmType::class)
            ->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setLocked(false);
            $this->repository->add($user, true);
            $this->addFlash('success', $this->translator->trans('The user has been unlocked.'));
            $default = $this->generateUrl('admin_user_list', [], UrlGeneratorInterface::ABSOLUTE_URL);

            return $this->redirect($request->headers->get('Referer', $default));
        }

        return $this->render('admin/user/unlock.html.twig', [
            'form' => $form->createView(),
            'user' => $user,
        ]);
    }
}
