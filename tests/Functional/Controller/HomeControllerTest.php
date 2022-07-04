<?php

declare(strict_types=1);

namespace Tests\Functional\Controller;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class HomeControllerTest extends WebTestCase
{
    private KernelBrowser $client;

    public function setUp(): void
    {
        $this->client = self::createClient();
    }

    /**
     * @testdox Accessing "/" returns an HTTP 200 response.
     */
    public function testHome(): void
    {
        $this->client->request('GET', '/');

        self::assertResponseStatusCodeSame(200);
    }
}
