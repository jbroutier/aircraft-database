<?php

declare(strict_types=1);

namespace Tests\Functional\Controller;

use App\Factory\TokenFactory;
use App\Factory\UserFactory;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

final class PasswordResetControllerTest extends WebTestCase
{
    use Factories;
    use ResetDatabase;

    private KernelBrowser $client;

    public function setUp(): void
    {
        $this->client = self::createClient();
    }

    /**
     * @testdox Accessing "/password-reset" returns an HTTP 200 response.
     */
    public function testRequest(): void
    {
        $this->client->request('GET', '/password-reset');

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('h1', 'Password reset');
    }

    /**
     * @testdox Submitting "/password-reset" sends the reset link.
     */
    public function testRequestSubmit(): void
    {
        UserFactory::createOne(['email' => 'dallin.kris27@yahoo.com']);

        $this->client->request('GET', '/password-reset');
        $this->client->submitForm('Reset password', [
            'request_password_reset[email]' => 'dallin.kris27@yahoo.com',
        ]);
        $this->client->followRedirect();

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('div', 'We have sent you a link to reset your password.');
    }

    /**
     * @testdox Accessing "/password-reset/{token}" returns an HTTP 200 response.
     */
    public function testReset(): void
    {
        $now = new \DateTimeImmutable('now', new \DateTimeZone('UTC'));
        $expiresAt = $now->modify('+1 hour');

        TokenFactory::createOne([
            'expiresAt' => $expiresAt,
            'role' => 'reset_password',
            'token' => '1845822d2a8f48ce8ef6e2fd82b668cf',
            'user' => UserFactory::createOne(),
        ]);

        $this->client->request('GET', '/password-reset/1845822d2a8f48ce8ef6e2fd82b668cf');

        self::assertResponseStatusCodeSame(200);
    }

    /**
     * @testdox Accessing "/password-reset/{token}" with an expired token returns an HTTP 404 response.
     */
    public function testResetWithExpiredToken(): void
    {
        $now = new \DateTimeImmutable('now', new \DateTimeZone('UTC'));
        $expiresAt = $now->modify('-1 hour');

        TokenFactory::createOne([
            'expiresAt' => $expiresAt,
            'role' => 'reset_password',
            'token' => '412023d13e6a472a94b77ef2c1668555',
            'user' => UserFactory::createOne(),
        ]);

        $this->client->request('GET', '/password-reset/412023d13e6a472a94b77ef2c1668555');

        self::assertResponseStatusCodeSame(404);
    }

    /**
     * @testdox Accessing "/password-reset/{token}" with an invalid token returns an HTTP 404 response.
     */
    public function testResetWithInvalidToken(): void
    {
        $this->client->request('GET', '/password-reset/3667801eaa984b97b93ae65fee99dcba');

        self::assertResponseStatusCodeSame(404);
    }

    /**
     * @testdox Submitting "/password-reset/{token}" resets the password.
     */
    public function testResetSubmit(): void
    {
        $now = new \DateTimeImmutable('now', new \DateTimeZone('UTC'));
        $expiresAt = $now->modify('+1 hour');

        TokenFactory::createOne([
            'expiresAt' => $expiresAt,
            'role' => 'reset_password',
            'token' => '9038e5ba0daa4a9a9e53702503ee243b',
            'user' => UserFactory::createOne(),
        ]);

        $this->client->request('GET', '/password-reset/9038e5ba0daa4a9a9e53702503ee243b');
        $this->client->submitForm('Reset password', [
            'reset_password[plainPassword][first]' => '#VzvQk9TH!',
            'reset_password[plainPassword][second]' => '#VzvQk9TH!',
        ]);
        $this->client->followRedirect();

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('div', 'Your password has been reset.');
    }
}
