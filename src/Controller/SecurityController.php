<?php

declare(strict_types=1);

namespace App\Controller;

use App\Form\LoginType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Contracts\Translation\TranslatorInterface;
use WhiteOctober\BreadcrumbsBundle\Model\Breadcrumbs;

class SecurityController extends AbstractController
{
    public function __construct(
        protected readonly AuthenticationUtils $authenticationUtils,
        protected readonly Breadcrumbs $breadcrumbs,
        protected readonly TranslatorInterface $translator
    ) {
    }

    #[Route(path: '/login', name: 'security_login')]
    public function login(Request $request): Response
    {
        $this->breadcrumbs->addItem('Home', $this->generateUrl('home'));
        $this->breadcrumbs->addItem('Sign in', $this->generateUrl('security_login'));

        $form = $this
            ->createForm(LoginType::class)
            ->handleRequest($request);

        if (!$form->isSubmitted()) {
            $form->setData(['email' => $this->authenticationUtils->getLastUsername()]);
        }

        if (!is_null($error = $this->authenticationUtils->getLastAuthenticationError())) {
            $this->addFlash('danger', $this->translator->trans($error->getMessageKey(), $error->getMessageData()));
        }

        return $this->render('security/login.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route(path: '/logout', name: 'security_logout')]
    public function logout(): void
    {
    }
}
