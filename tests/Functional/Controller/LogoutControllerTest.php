<?php

declare(strict_types=1);

namespace Tests\Functional\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class LogoutControllerTest extends WebTestCase
{
    /**
     * @testdox Accessing "/logout" redirects to the index.
     */
    public function testLogout(): void
    {
        $client = self::createClient();
        $client->request('GET', '/logout');

        self::assertResponseRedirects(null, 302);
    }
}
