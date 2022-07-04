<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use WhiteOctober\BreadcrumbsBundle\Model\Breadcrumbs;

class HomeController extends AbstractController
{
    public function __construct(protected readonly Breadcrumbs $breadcrumbs)
    {
    }

    #[Route(path: '/', name: 'home')]
    public function __invoke(): Response
    {
        $this->breadcrumbs->addItem('Home', $this->generateUrl('home'));

        return $this->render('home.html.twig');
    }
}
