<?php

declare(strict_types=1);

namespace Tests\Functional\Controller;

use App\Factory\TokenFactory;
use App\Factory\UserFactory;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

final class RegistrationControllerTest extends WebTestCase
{
    use Factories;
    use ResetDatabase;

    private KernelBrowser $client;

    public function setUp(): void
    {
        $this->client = self::createClient();
    }

    /**
     * @testdox Accessing "/register" returns an HTTP 200 response.
     */
    public function testRegister(): void
    {
        $this->client->request('GET', '/register');

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('h1', 'Sign up');
    }

    /**
     * @testdox Accessing "/confirm-email/{token}" activates the account.
     */
    public function testConfirmEmail(): void
    {
        $now = new \DateTimeImmutable('now', new \DateTimeZone('UTC'));
        $expiresAt = $now->modify('+1 hour');

        TokenFactory::createOne([
            'expiresAt' => $expiresAt,
            'role' => 'register',
            'token' => '0108969dcaa94de8b4a21a0ba4f76339',
            'user' => UserFactory::createOne(),
        ]);

        $this->client->request('GET', '/confirm-email/0108969dcaa94de8b4a21a0ba4f76339');
        $this->client->followRedirect();

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('div', 'Your email address has been confirmed.');
    }

    /**
     * @testdox Accessing "/confirm-email/{token}" with an expired token returns an HTTP 404 response.
     */
    public function testConfirmEmailWithExpiredToken(): void
    {
        $now = new \DateTimeImmutable('now', new \DateTimeZone('UTC'));
        $expiresAt = $now->modify('-1 hour');

        TokenFactory::createOne([
            'expiresAt' => $expiresAt,
            'role' => 'register',
            'token' => '8f0d5e3663f54be0921d0bc867e90ca3',
            'user' => UserFactory::createOne(),
        ]);

        $this->client->request('GET', '/confirm-email/8f0d5e3663f54be0921d0bc867e90ca3');

        self::assertResponseStatusCodeSame(404);
    }

    /**
     * @testdox Accessing "/confirm-email/{token}" with an invalid token returns an HTTP 404 response.
     */
    public function testConfirmEmailWithInvalidToken(): void
    {
        $this->client->request('GET', '/confirm-email/e0cc18c6d0d64a56831d5cd7a0422562');

        self::assertResponseStatusCodeSame(404);
    }

    /**
     * @testdox Submitting "/register" creates the user.
     */
    public function testRegisterSubmit(): void
    {
        $this->client->request('GET', '/register');
        $this->client->submitForm('Sign up', [
            'register[consenting]' => '1',
            'register[email]' => 'jeremie.broutier@posteo.net',
            'register[firstName]' => 'Jérémie',
            'register[lastName]' => 'Broutier',
            'register[plainPassword][first]' => '#8kefBwcV$',
            'register[plainPassword][second]' => '#8kefBwcV$',
        ]);
        $this->client->followRedirect();

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('div', 'Your account has been created. Please confirm your email address.');
    }
}
