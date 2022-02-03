<?php

declare(strict_types=1);

namespace App\Controller;

use App\Form\QueryType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    #[Route(path: '/', name: 'index')]
    public function __invoke(): Response
    {
        $form = $this->createForm(QueryType::class, null, [
            'action' => $this->generateUrl('search'),
            'method' => 'get',
        ]);

        return $this->render('index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
