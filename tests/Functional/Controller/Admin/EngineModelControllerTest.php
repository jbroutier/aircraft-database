<?php

declare(strict_types=1);

namespace Tests\Functional\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Tests\Functional\Controller\Traits\FixturesAwareTrait;

final class EngineModelControllerTest extends WebTestCase
{
    use FixturesAwareTrait;

    /**
     * @testdox Accessing /admin/engine-models/create returns an HTTP 200 response.
     */
    public function testCreate(): void
    {
        $client = self::createClient();
        $client->loginUser($this->getUser('admin'));
        $client->request('GET', '/admin/engine-models/create');

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('h5', 'New engine model');
    }

    /**
     * @testdox Accessing /admin/engine-models returns an HTTP 200 response.
     */
    public function testList(): void
    {
        $client = self::createClient();
        $client->loginUser($this->getUser('admin'));
        $client->request('GET', '/admin/engine-models');

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('h1', 'Engine models');
    }

    /**
     * @testdox Accessing /admin/engine-models with an invalid page returns an HTTP 404 response.
     */
    public function testListWithInvalidPage(): void
    {
        $client = self::createClient();
        $client->loginUser($this->getUser('admin'));
        $client->request('GET', '/admin/engine-models', ['page' => 101]);

        self::assertResponseStatusCodeSame(404);
    }
}
