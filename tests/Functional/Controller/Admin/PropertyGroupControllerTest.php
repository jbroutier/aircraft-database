<?php

declare(strict_types=1);

namespace Tests\Functional\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Tests\Functional\Controller\Traits\FixturesAwareTrait;

final class PropertyGroupControllerTest extends WebTestCase
{
    use FixturesAwareTrait;

    /**
     * @testdox Accessing /admin/property-groups/create returns an HTTP 200 response.
     */
    public function testCreate(): void
    {
        $client = self::createClient();
        $client->loginUser($this->getUser('admin'));
        $client->request('GET', '/admin/property-groups/create');

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('h5', 'New property group');
    }

    /**
     * @testdox Accessing /admin/property-groups returns an HTTP 200 response.
     */
    public function testList(): void
    {
        $client = self::createClient();
        $client->loginUser($this->getUser('admin'));
        $client->request('GET', '/admin/property-groups');

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('h1', 'Property groups');
    }

    /**
     * @testdox Accessing /admin/property-groups with an invalid page returns an HTTP 404 response.
     */
    public function testListWithInvalidPage(): void
    {
        $client = self::createClient();
        $client->loginUser($this->getUser('admin'));
        $client->request('GET', '/admin/property-groups', ['page' => 101]);

        self::assertResponseStatusCodeSame(404);
    }
}
