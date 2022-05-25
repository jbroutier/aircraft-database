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

class LoginController extends AbstractController
{
    #[Route(path: '/login', name: 'login')]
    public function __invoke(Request $request, AuthenticationUtils $authenticationUtils): Response
    {
        $form = $this->createForm(LoginType::class);
        $form->handleRequest($request);

        if (!is_null($error = $authenticationUtils->getLastAuthenticationError())) {
            $form->get('username')->addError(
                new FormError($error->getMessage(), $error->getMessageKey(), $error->getMessageData())
            );
        }

        return $this->render('login.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
