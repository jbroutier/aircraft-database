<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\User;
use App\Form\UpdatePasswordType;
use App\Form\UpdateProfileType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Symfony\Contracts\Translation\TranslatorInterface;
use WhiteOctober\BreadcrumbsBundle\Model\Breadcrumbs;

class UserController extends AbstractController
{
    public function __construct(
        protected readonly Breadcrumbs $breadcrumbs,
        protected readonly TranslatorInterface $translator,
        protected readonly UserRepository $repository
    ) {
    }

    #[Route(path: '/user/update-password', name: 'user_update_password')]
    public function updatePassword(Request $request, #[CurrentUser] User $user): Response
    {
        $this->breadcrumbs->addItem('Home', $this->generateUrl('home'));
        $this->breadcrumbs->addItem('Update password', $this->generateUrl('user_update_password'));

        $form = $this
            ->createForm(UpdatePasswordType::class, $user)
            ->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->repository->add($user, true);
            $this->addFlash('success', $this->translator->trans('Your password has been updated.'));
        }

        return $this->render('user/update_password.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route(path: '/user/update-profile', name: 'user_update_profile')]
    public function updateProfile(Request $request, #[CurrentUser] User $user): Response
    {
        $this->breadcrumbs->addItem('Home', $this->generateUrl('home'));
        $this->breadcrumbs->addItem('Update profile', $this->generateUrl('user_update_profile'));

        $form = $this
            ->createForm(UpdateProfileType::class, $user)
            ->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->repository->add($user, true);
            $this->addFlash('success', $this->translator->trans('Your profile has been updated.'));
        }

        return $this->render('user/update_profile.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
