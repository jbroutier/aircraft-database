<?php

declare(strict_types=1);

namespace App\Controller\OAuth;

use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GoogleController extends AbstractController
{
    public function __construct(protected readonly ClientRegistry $clientRegistry)
    {
    }

    #[Route(path: '/oauth/google/check', name: 'oauth_google_check')]
    public function check(): void
    {
    }

    #[Route(path: '/oauth/google/login', name: 'oauth_google_login')]
    public function login(): Response
    {
        return $this->clientRegistry
            ->getClient('google')
            ->redirect(['openid', 'profile', 'email'], ['state' => bin2hex(openssl_random_pseudo_bytes(16))]);
    }
}
