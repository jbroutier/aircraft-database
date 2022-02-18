<?php

declare(strict_types=1);

namespace Tests\Functional\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Tests\Functional\Controller\Traits\FixturesAwareTrait;

final class ManufacturerControllerTest extends WebTestCase
{
    use FixturesAwareTrait;

    /**
     * @testdox Accessing /admin/manufacturers/create returns an HTTP 200 response.
     */
    public function testCreate(): void
    {
        $client = self::createClient();
        $client->loginUser($this->getUser('admin'));
        $client->request('GET', '/admin/manufacturers/create');

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('h5', 'New manufacturer');
    }

    /**
     * @testdox Accessing /admin/manufacturers returns an HTTP 200 response.
     */
    public function testList(): void
    {
        $client = self::createClient();
        $client->loginUser($this->getUser('admin'));
        $client->request('GET', '/admin/manufacturers');

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('h1', 'Manufacturers');
    }

    /**
     * @testdox Accessing /admin/manufacturers with an invalid page returns an HTTP 404 response.
     */
    public function testListWithInvalidPage(): void
    {
        $client = self::createClient();
        $client->loginUser($this->getUser('admin'));
        $client->request('GET', '/admin/manufacturers', ['page' => 101]);

        self::assertResponseStatusCodeSame(404);
    }
}
