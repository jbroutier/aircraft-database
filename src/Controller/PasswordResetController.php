<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\User;
use App\Form\RequestPasswordResetType;
use App\Form\ResetPasswordType;
use App\Model\RequestPasswordResetModel;
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
use Symfony\Contracts\Translation\TranslatorInterface;
use WhiteOctober\BreadcrumbsBundle\Model\Breadcrumbs;

class PasswordResetController extends AbstractController
{
    public function __construct(
        protected readonly Breadcrumbs $breadcrumbs,
        protected readonly LoggerInterface $logger,
        protected readonly MailerInterface $mailer,
        protected readonly TokenGenerator $tokenGenerator,
        protected readonly TokenRepository $tokenRepository,
        protected readonly TranslatorInterface $translator,
        protected readonly UserRepository $userRepository
    ) {
    }

    #[Route(path: '/password-reset', name: 'password_reset_request')]
    public function request(Request $request): Response
    {
        $this->breadcrumbs->addItem('Home', $this->generateUrl('home'));
        $this->breadcrumbs->addItem('Password reset', $this->generateUrl('password_reset_request'));

        $form = $this
            ->createForm(RequestPasswordResetType::class)
            ->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var RequestPasswordResetModel $data */
            $data = $form->getData();

            if (!is_null($user = $this->userRepository->findOneBy(['email' => $data->email]))) {
                $token = $this->tokenGenerator->generate($user, 'reset_password', 3600);

                $email = (new TemplatedEmail())
                    ->to(new Address((string)$user->getEmail(), $user->getFullName()))
                    ->subject($this->translator->trans('Reset your password'))
                    ->htmlTemplate('email/password_reset.mjml.twig')
                    ->context([
                        'token' => $token,
                        'user' => $user,
                    ]);

                try {
                    $this->mailer->send($email);
                } catch (TransportExceptionInterface $exception) {
                    $this->logger->error($exception->getMessage());
                }

                $this->tokenRepository->add($token, true);
            }

            $this->addFlash('success', $this->translator->trans('We have sent you a link to reset your password.'));

            return $this->redirectToRoute('security_login');
        }

        return $this->render('password_reset/request.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route(path: '/password-reset/{token}', name: 'password_reset_reset')]
    public function reset(Request $request): Response
    {
        $token = $request->attributes->get('token');

        if (is_null($token = $this->tokenRepository->findOneBy(['token' => $token]))) {
            throw new NotFoundHttpException();
        }

        if (!$token->isValid('reset_password')) {
            $this->tokenRepository->remove($token, true);
            throw new NotFoundHttpException();
        }

        $this->breadcrumbs->addItem('Home', $this->generateUrl('home'));
        $this->breadcrumbs->addItem('Password reset', $this->generateUrl('password_reset_request'));

        /** @var User $user */
        $user = $token->getUser();
        $form = $this
            ->createForm(ResetPasswordType::class, $user)
            ->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setUpdatedAt(new \DateTimeImmutable('now', new \DateTimeZone('UTC'))); // Force the entity update.
            $this->userRepository->add($user, true);
            $this->tokenRepository->remove($token, true);
            $this->addFlash('success', $this->translator->trans('Your password has been reset.'));

            return $this->redirectToRoute('security_login');
        }

        return $this->render('password_reset/reset.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
