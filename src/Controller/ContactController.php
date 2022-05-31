<?php

declare(strict_types=1);

namespace App\Controller;

use App\Form\ContactType;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use WhiteOctober\BreadcrumbsBundle\Model\Breadcrumbs;

class ContactController extends AbstractController
{
    public function __construct(
        protected readonly Breadcrumbs $breadcrumbs,
        protected readonly LoggerInterface $logger,
        protected readonly MailerInterface $mailer,
        protected readonly TranslatorInterface $translator
    ) {
    }

    #[Route(path: '/contact', name: 'contact')]
    public function __invoke(Request $request): Response
    {
        $this->breadcrumbs->addItem('Index', $this->generateUrl('index'));
        $this->breadcrumbs->addItem('Contact', $this->generateUrl('contact'));

        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $email = new Email();
            $email
                ->replyTo(new Address($data->address, $data->name))
                ->subject($data->subject)
                ->text($data->message);

            try {
                $this->mailer->send($email);
                $this->addFlash('success', $this->translator->trans('Your message has been sent.'));
            } catch (TransportExceptionInterface $exception) {
                $this->logger->error($exception->getMessage());
                $this->addFlash('danger', $this->translator->trans('An error has occurred. Please try again later.'));
            }
        }

        return $this->render('contact.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
