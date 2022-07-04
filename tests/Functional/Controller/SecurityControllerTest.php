<?php

declare(strict_types=1);

namespace Tests\Functional\Controller;

use App\Factory\UserFactory;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

final class SecurityControllerTest extends WebTestCase
{
    use Factories;
    use ResetDatabase;

    private KernelBrowser $client;

    public function setUp(): void
    {
        $this->client = self::createClient();
    }

    /**
     * @testdox Accessing "/login" returns an HTTP 200 response.
     */
    public function testLogin(): void
    {
        $this->client->request('GET', '/login');

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('h1', 'Sign in');
    }

    /**
     * @testdox Submitting "/login" logs the user in.
     */
    public function testSubmitLogin(): void
    {
        UserFactory::createOne([
            'email' => 'jeremie.broutier@posteo.net',
            'enabled' => true,
            'firstName' => 'Jérémie',
            'lastName' => 'Broutier',
            'locked' => false,
            'plainPassword' => 'admin',
        ]);

        $this->client->request('GET', '/login');
        $this->client->submitForm('Sign in', [
            'login[email]' => 'jeremie.broutier@posteo.net',
            'login[password]' => 'admin',
        ]);
        $this->client->followRedirect();

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('nav', 'Jérémie Broutier');
    }

    /**
     * @testdox Submitting "/login" with invalid credentials shows an error message.
     */
    public function testSubmitLoginWithInvalidCredentials(): void
    {
        $this->client->request('GET', '/login');
        $this->client->submitForm('Sign in', [
            'login[email]' => 'invalid-email',
            'login[password]' => 'invalid-password',
        ]);
        $this->client->followRedirect();

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('div', 'Invalid credentials.');
    }

    /**
     * @testdox Submitting "/login" with a disabled account shows an error message.
     */
    public function testSubmitLoginWithDisabledAccount(): void
    {
        UserFactory::createOne([
            'email' => 'dylan82@hotmail.com',
            'enabled' => false,
            'locked' => false,
            'plainPassword' => '$qxkVzJ2r!',
        ]);

        $this->client->request('GET', '/login');
        $this->client->submitForm('Sign in', [
            'login[email]' => 'dylan82@hotmail.com',
            'login[password]' => '$qxkVzJ2r!',
        ]);
        $this->client->followRedirect();

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('div', 'You must confirm your email address.');
    }

    /**
     * @testdox Submitting "/login" with a locked account shows an error message.
     */
    public function testSubmitLoginWithLockedAccount(): void
    {
        UserFactory::createOne([
            'email' => 'antonia_bogan15@yahoo.com',
            'enabled' => true,
            'locked' => true,
            'plainPassword' => '#TQ9379Eo!',
        ]);

        $this->client->request('GET', '/login');
        $this->client->submitForm('Sign in', [
            'login[email]' => 'antonia_bogan15@yahoo.com',
            'login[password]' => '#TQ9379Eo!',
        ]);
        $this->client->followRedirect();

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('div', 'Your account has been locked.');
    }

    /**
     * @testdox Accessing "/logout" returns an HTTP 200 response.
     */
    public function testLogout(): void
    {
        $this->client->request('GET', '/logout');
        $this->client->followRedirect();

        self::assertResponseStatusCodeSame(200);
    }
}
