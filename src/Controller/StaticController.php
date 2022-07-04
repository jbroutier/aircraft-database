<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use WhiteOctober\BreadcrumbsBundle\Model\Breadcrumbs;

class StaticController extends AbstractController
{
    public function __construct(protected readonly Breadcrumbs $breadcrumbs)
    {
    }

    #[Route(path: '/cookie-policy', name: 'static_cookie_policy')]
    public function cookiePolicy(): Response
    {
        $this->breadcrumbs->addItem('Home', $this->generateUrl('home'));
        $this->breadcrumbs->addItem('Cookie policy', $this->generateUrl('static_cookie_policy'));

        return $this->render('static/cookie_policy.html.twig');
    }

    #[Route(path: '/legal-notice', name: 'static_legal_notice')]
    public function legalNotice(): Response
    {
        $this->breadcrumbs->addItem('Home', $this->generateUrl('home'));
        $this->breadcrumbs->addItem('Legal notice', $this->generateUrl('static_legal_notice'));

        return $this->render('static/legal_notice.html.twig');
    }

    #[Route(path: '/privacy-policy', name: 'static_privacy_policy')]
    public function privacyPolicy(): Response
    {
        $this->breadcrumbs->addItem('Home', $this->generateUrl('home'));
        $this->breadcrumbs->addItem('Privacy policy', $this->generateUrl('static_privacy_policy'));

        return $this->render('static/privacy_policy.html.twig');
    }
}
