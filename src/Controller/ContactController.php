<?php

declare(strict_types=1);

namespace App\Controller;

use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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

            $this->mailer->send($email);

            $this->addFlash('success', $this->translator->trans('Message sent.'));
        }

        return $this->render('contact.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
