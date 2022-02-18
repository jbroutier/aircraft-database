<?php

declare(strict_types=1);

namespace Tests\Functional\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class LoginControllerTest extends WebTestCase
{
    /**
     * @testdox Accessing /login returns an HTTP 200 response.
     */
    public function testLogin(): void
    {
        $client = self::createClient();
        $client->request('GET', '/login');

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('h1', 'Login');
    }
}
