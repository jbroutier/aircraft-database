<?php

declare(strict_types=1);

namespace Tests\Functional\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Tests\Functional\Controller\Traits\FixturesAwareTrait;

final class TagControllerTest extends WebTestCase
{
    use FixturesAwareTrait;

    /**
     * @testdox Accessing /admin/tags/create returns an HTTP 200 response.
     */
    public function testCreate(): void
    {
        $client = self::createClient();
        $client->loginUser($this->getUser('admin'));
        $client->request('GET', '/admin/tags/create');

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('h5', 'New tag');
    }

    /**
     * @testdox Accessing /admin/tags returns an HTTP 200 response.
     */
    public function testList(): void
    {
        $client = self::createClient();
        $client->loginUser($this->getUser('admin'));
        $client->request('GET', '/admin/tags');

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('h1', 'Tags');
    }

    /**
     * @testdox Accessing /admin/tags with an invalid page returns an HTTP 404 response.
     */
    public function testListWithInvalidPage(): void
    {
        $client = self::createClient();
        $client->loginUser($this->getUser('admin'));
        $client->request('GET', '/admin/tags', ['page' => 101]);

        self::assertResponseStatusCodeSame(404);
    }
}
