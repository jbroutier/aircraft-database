<?php

declare(strict_types=1);

namespace Tests\Functional\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Tests\Functional\Controller\Traits\FixturesAwareTrait;

final class PropertyControllerTest extends WebTestCase
{
    use FixturesAwareTrait;

    /**
     * @testdox Accessing /admin/properties/create returns an HTTP 200 response.
     */
    public function testCreate(): void
    {
        $client = self::createClient();
        $client->loginUser($this->getUser('admin'));
        $client->request('GET', '/admin/properties/create');

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('h5', 'New property');
    }

    /**
     * @testdox Accessing /admin/properties returns an HTTP 200 response.
     */
    public function testList(): void
    {
        $client = self::createClient();
        $client->loginUser($this->getUser('admin'));
        $client->request('GET', '/admin/properties');

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('h1', 'Properties');
    }

    /**
     * @testdox Accessing /admin/properties with an invalid page returns an HTTP 404 response.
     */
    public function testListWithInvalidPage(): void
    {
        $client = self::createClient();
        $client->loginUser($this->getUser('admin'));
        $client->request('GET', '/admin/properties', ['page' => 101]);

        self::assertResponseStatusCodeSame(404);
    }
}
