<?php

declare(strict_types=1);

namespace Tests\Functional\Controller\Database;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class AircraftModelControllerTest extends WebTestCase
{
    /**
     * @testdox Accessing /database/aircraft-models returns an HTTP 200 response.
     */
    public function testList(): void
    {
        $client = self::createClient();
        $client->request('GET', '/database/aircraft-models');

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('h1', 'Aircraft models');
    }

    /**
     * @testdox Accessing /database/aircraft-models with an invalid slug returns an HTTP 404 response.
     */
    public function testListWithInvalidSlug(): void
    {
        $client = self::createClient();
        $client->request('GET', '/database/aircraft-models', ['page' => 101]);

        self::assertResponseStatusCodeSame(404);
    }

    /**
     * @testdox Accessing /database/aircraft-models/{slug} returns an HTTP 200 response.
     * @noinspection SpellCheckingInspection
     */
    public function testRead(): void
    {
        $client = self::createClient();
        $client->request('GET', '/database/aircraft-models/est-ea-ut-aut-et-et-odit');

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('h1', 'A0-3552');
    }

    /**
     * @testdox Accessing /database/aircraft-models/{slug} with an invalid slug returns an HTTP 404 response.
     * @noinspection SpellCheckingInspection
     */
    public function testReadWithInvalidSlug(): void
    {
        $client = self::createClient();
        $client->request('GET', '/database/aircraft-models/augue-quis-convallis');

        self::assertResponseStatusCodeSame(404);
    }
}
