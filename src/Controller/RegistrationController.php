<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\User;
use App\Enum\RegistrationMethod;
use App\Form\RegisterType;
use App\Repository\TokenRepository;
use App\Repository\UserRepository;
use App\Security\TokenGenerator;
use Psr\Log\LoggerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Contracts\Translation\TranslatorInterface;
use WhiteOctober\BreadcrumbsBundle\Model\Breadcrumbs;

class RegistrationController extends AbstractController
{
    public function __construct(
        protected readonly Breadcrumbs $breadcrumbs,
        protected readonly LoggerInterface $logger,
        protected readonly MailerInterface $mailer,
        protected readonly TokenGenerator $tokenGenerator,
        protected readonly TokenRepository $tokenRepository,
        protected readonly TokenStorageInterface $tokenStorage,
        protected readonly TranslatorInterface $translator,
        protected readonly UserRepository $userRepository
    ) {
    }

    #[Route(path: '/confirm-email/{token}', name: 'registration_confirm_email')]
    public function confirmEmail(Request $request): Response
    {
        $token = $request->attributes->get('token');

        if (is_null($token = $this->tokenRepository->findOneBy(['token' => $token]))) {
            throw new NotFoundHttpException();
        }

        if (!$token->isValid('register')) {
            $this->tokenRepository->remove($token, true);
            throw new NotFoundHttpException();
        }

        /** @var User $user */
        $user = $token->getUser();
        $user->setEnabled(true);

        $this->userRepository->add($user, true);
        $this->tokenRepository->remove($token, true);
        $this->tokenStorage->setToken(new UsernamePasswordToken($user, 'main', $user->getRoles()));
        $this->addFlash('success', $this->translator->trans('Your email address has been confirmed.'));

        return $this->redirectToRoute('home');
    }

    #[Route(path: '/register', name: 'registration_register')]
    public function register(Request $request): Response
    {
        $this->breadcrumbs->addItem('Home', $this->generateUrl('home'));
        $this->breadcrumbs->addItem('Sign up', $this->generateUrl('registration_register'));

        $form = $this
            ->createForm(RegisterType::class)
            ->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var User $user */
            $user = $form->getData();
            $user->setRegistrationMethod(RegistrationMethod::RegistrationForm);
            $token = $this->tokenGenerator->generate($user, 'register', 86400);

            $email = (new TemplatedEmail())
                ->to(new Address((string)$user->getEmail(), $user->getFullName()))
                ->subject($this->translator->trans('Confirm your email address'))
                ->htmlTemplate('email/register.mjml.twig')
                ->context([
                    'token' => $token,
                    'user' => $user,
                ]);

            try {
                $this->mailer->send($email);
            } catch (TransportExceptionInterface $exception) {
                $this->logger->error($exception->getMessage());
                $this->addFlash('danger', $this->translator->trans('An error has occurred. Please try again later.'));

                return $this->redirectToRoute('registration_register');
            }

            $this->userRepository->add($user, true);
            $this->tokenRepository->add($token, true);
            $this->addFlash(
                'success',
                $this->translator->trans('Your account has been created. Please confirm your email address.')
            );

            return $this->redirectToRoute('security_login');
        }

        return $this->render('registration/register.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
