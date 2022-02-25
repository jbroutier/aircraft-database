<?php

declare(strict_types=1);

namespace Tests\Functional\Controller\Database;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class AircraftTypeControllerTest extends WebTestCase
{
    /**
     * @testdox Accessing "/database/aircraft-types" returns an HTTP 200 response.
     */
    public function testList(): void
    {
        $client = self::createClient();
        $client->request('GET', '/database/aircraft-types');

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('h1', 'Aircraft types');
    }

    /**
     * @testdox Accessing "/database/aircraft-types" with an invalid slug returns an HTTP 404 response.
     */
    public function testListWithInvalidSlug(): void
    {
        $client = self::createClient();
        $client->request('GET', '/database/aircraft-types', ['page' => 100]);

        self::assertResponseStatusCodeSame(404);
    }

    /**
     * @testdox Accessing "/database/aircraft-types/{slug}" returns an HTTP 200 response.
     * @noinspection SpellCheckingInspection
     */
    public function testRead(): void
    {
        $client = self::createClient();
        $client->request('GET', '/database/aircraft-types/dignissimos-perspiciatis-praesentium-ab-ut');

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('h1', 'A036-7');
    }

    /**
     * @testdox Accessing "/database/aircraft-types/{slug}" with an invalid slug returns an HTTP 404 response.
     * @noinspection SpellCheckingInspection
     */
    public function testReadWithInvalidSlug(): void
    {
        $client = self::createClient();
        $client->request('GET', '/database/aircraft-types/donec-eu-massa-luctus');

        self::assertResponseStatusCodeSame(404);
    }
}
