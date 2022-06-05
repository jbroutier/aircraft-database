<?php

declare(strict_types=1);

namespace App\Controller;

use App\Form\LoginType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    public function __construct(protected readonly AuthenticationUtils $authenticationUtils)
    {
    }

    #[Route(path: '/login', name: 'security_login')]
    public function login(Request $request): Response
    {
        $form = $this->createForm(LoginType::class);
        $form->handleRequest($request);

        if (!is_null($error = $this->authenticationUtils->getLastAuthenticationError())) {
            $form->get('username')->addError(
                new FormError($error->getMessage(), $error->getMessageKey(), $error->getMessageData())
            );
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
