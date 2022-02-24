<?php

declare(strict_types=1);

namespace Tests\Functional\Controller\Database;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class EngineModelControllerTest extends WebTestCase
{
    /**
     * @testdox Accessing "/database/engine-models" returns an HTTP 200 response.
     */
    public function testList(): void
    {
        $client = self::createClient();
        $client->request('GET', '/database/engine-models');

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('h1', 'Engine models');
    }

    /**
     * @testdox Accessing "/database/engine-models" with an invalid slug returns an HTTP 404 response.
     */
    public function testListWithInvalidSlug(): void
    {
        $client = self::createClient();
        $client->request('GET', '/database/engine-models', ['page' => 100]);

        self::assertResponseStatusCodeSame(404);
    }

    /**
     * @testdox Accessing "/database/engine-models/{slug}" returns an HTTP 200 response.
     * @noinspection SpellCheckingInspection
     */
    public function testRead(): void
    {
        $client = self::createClient();
        $client->request('GET', '/database/engine-models/enim-omnis-nemo-aut-eius');

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('h1', 'D28-86');
    }

    /**
     * @testdox Accessing "/database/engine-models/{slug}" with an invalid slug returns an HTTP 404 response.
     * @noinspection SpellCheckingInspection
     */
    public function testReadWithInvalidSlug(): void
    {
        $client = self::createClient();
        $client->request('GET', '/database/engine-models/facilisis-nibh-nec');

        self::assertResponseStatusCodeSame(404);
    }
}
