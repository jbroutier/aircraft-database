<?php

declare(strict_types=1);

namespace Tests\Functional\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Tests\Functional\Controller\Traits\FixturesAwareTrait;

final class AircraftTypeControllerTest extends WebTestCase
{
    use FixturesAwareTrait;

    /**
     * @testdox Accessing /admin/aircraft-types/create returns an HTTP 200 response.
     */
    public function testCreate(): void
    {
        $client = self::createClient();
        $client->loginUser($this->getUser('admin'));
        $client->request('GET', '/admin/aircraft-types/create');

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('h5', 'New aircraft type');
    }

    /**
     * @testdox Accessing /admin/aircraft-types returns an HTTP 200 response.
     */
    public function testList(): void
    {
        $client = self::createClient();
        $client->loginUser($this->getUser('admin'));
        $client->request('GET', '/admin/aircraft-types');

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('h1', 'Aircraft types');
    }

    /**
     * @testdox Accessing /admin/aircraft-types with an invalid page returns an HTTP 404 response.
     */
    public function testListWithInvalidPage(): void
    {
        $client = self::createClient();
        $client->loginUser($this->getUser('admin'));
        $client->request('GET', '/admin/aircraft-types', ['page' => 101]);

        self::assertResponseStatusCodeSame(404);
    }
}
