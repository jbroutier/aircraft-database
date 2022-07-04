<?php

declare(strict_types=1);

namespace App\Security\Authenticator;

use App\Entity\User;
use App\Enum\RegistrationMethod;
use App\Repository\UserRepository;
use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use KnpU\OAuth2ClientBundle\Security\Authenticator\OAuth2Authenticator;
use League\OAuth2\Client\Provider\GoogleUser;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;
use Symfony\Component\Security\Http\HttpUtils;

class GoogleAuthenticator extends OAuth2Authenticator
{
    public function __construct(
        protected readonly ClientRegistry $clientRegistry,
        protected readonly HttpUtils $httpUtils,
        protected readonly UserRepository $repository
    ) {
    }

    public function supports(Request $request): bool
    {
        return $this->httpUtils->checkRequestPath($request, 'oauth_google_check');
    }

    public function authenticate(Request $request): Passport
    {
        $client = $this->clientRegistry->getClient('google');
        $token = $this->fetchAccessToken($client);

        return new SelfValidatingPassport(
            new UserBadge($token->getToken(), function () use ($token, $client) {
                /** @var GoogleUser $googleUser */
                $googleUser = $client->fetchUserFromToken($token);
                $user = $this->repository->findOneBy(['googleId' => $googleUser->getId()]);

                if (is_null($user)) {
                    $user = $this->repository->findOneBy(['email' => $googleUser->getEmail()]);

                    if (is_null($user)) {
                        $user = (new User())
                            ->setConsenting(true)
                            ->setEmail($googleUser->getEmail())
                            ->setFirstName($googleUser->getFirstName())
                            ->setLastName($googleUser->getLastName())
                            ->setPlainPassword(bin2hex(openssl_random_pseudo_bytes(16)))
                            ->setRegistrationMethod(RegistrationMethod::Google);
                    }

                    $user
                        ->setEnabled(true)
                        ->setGoogleId(strval($googleUser->getId()));

                    $this->repository->add($user, true);
                }

                return $user;
            })
        );
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): Response
    {
        return $this->httpUtils->createRedirectResponse($request, 'home');
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): Response
    {
        $message = strtr($exception->getMessageKey(), $exception->getMessageData());

        return new Response($message, Response::HTTP_FORBIDDEN);
    }
}
