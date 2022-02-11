<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Repository\LogoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class LogoController extends AbstractController
{
    public function __construct(
        protected LogoRepository $repository,
        protected EntityManagerInterface $entityManager
    ) {
    }

    #[Route(path: '/admin/logos/{id}/delete', name: 'admin_logo_delete')]
    public function delete(Request $request): Response
    {
        $id = $request->attributes->get('id');

        if (is_null($logo = $this->repository->findOneBy(['id' => $id]))) {
            throw new NotFoundHttpException();
        }

        $this->entityManager->remove($logo);
        $this->entityManager->flush();

        return new Response();
    }
}
