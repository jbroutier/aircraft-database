<?php
/**
 * @noinspection SpellCheckingInspection
 */

declare(strict_types=1);

namespace Tests\Functional\Controller\Database;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class ManufacturerControllerTest extends WebTestCase
{
    /**
     * @testdox Accessing /database/manufacturers returns an HTTP 200 response.
     */
    public function testList(): void
    {
        $client = self::createClient();
        $client->request('GET', '/database/manufacturers');

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('h1', 'Manufacturers');
    }

    /**
     * @testdox Accessing /database/manufacturers with an invalid slug returns an HTTP 404 response.
     */
    public function testListWithInvalidSlug(): void
    {
        $client = self::createClient();
        $client->request('GET', '/database/manufacturers', ['page' => 101]);

        self::assertResponseStatusCodeSame(404);
    }

    /**
     * @testdox Accessing /database/manufacturers/{slug} returns an HTTP 200 response.
     * @noinspection SpellCheckingInspection
     */
    public function testReadReturnsHttp200(): void
    {
        $client = self::createClient();
        $client->request('GET', '/database/manufacturers/facere-voluptatibus-voluptatum-est-quis');

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('h1', 'Bailey, Armstrong and Kshlerin');
    }

    /**
     * @testdox Accessing /database/manufacturers/{slug} with an invalid slug returns an HTTP 404 response.
     * @noinspection SpellCheckingInspection
     */
    public function testReadWithInvalidSlug(): void
    {
        $client = self::createClient();
        $client->request('GET', '/database/manufacturers/penatibus-et-magnis-dis');

        self::assertResponseStatusCodeSame(404);
    }
}
