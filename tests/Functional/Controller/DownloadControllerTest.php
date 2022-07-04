<?php

declare(strict_types=1);

namespace Tests\Functional\Controller;

use App\Entity\User;
use App\Factory\UserFactory;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Zenstruck\Foundry\Proxy;

final class DownloadControllerTest extends WebTestCase
{
    private KernelBrowser $client;

    public function setUp(): void
    {
        $this->client = self::createClient();

        /** @var Proxy<User> $user */
        $user = UserFactory::createOne();
        $this->client->loginUser($user->object());
    }

    /**
     * @testdox Accessing "/downloads/aircraft-models" returns an HTTP 200 response.
     */
    public function testAircraftModels(): void
    {
        file_put_contents('dump/aircraft-models.csv', '');

        $this->client->request('GET', '/downloads/aircraft-models');

        self::assertResponseStatusCodeSame(200);

        unlink('dump/aircraft-models.csv');
    }

    /**
     * @testdox Accessing "/downloads/aircraft-types" returns an HTTP 200 response.
     */
    public function testAircraftTypes(): void
    {
        file_put_contents('dump/aircraft-types.csv', '');

        $this->client->request('GET', '/downloads/aircraft-types');

        self::assertResponseStatusCodeSame(200);

        unlink('dump/aircraft-types.csv');
    }

    /**
     * @testdox Accessing "/downloads/engine-models" returns an HTTP 200 response.
     */
    public function testEngineModels(): void
    {
        file_put_contents('dump/engine-models.csv', '');

        $this->client->request('GET', '/downloads/engine-models');

        self::assertResponseStatusCodeSame(200);

        unlink('dump/engine-models.csv');
    }

    /**
     * @testdox Accessing "/downloads" returns an HTTP 200 response.
     */
    public function testIndex(): void
    {
        $this->client->request('GET', '/downloads');

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('h1', 'Downloads');
    }

    /**
     * @testdox Accessing "/downloads/manufacturers" returns an HTTP 200 response.
     */
    public function testManufacturers(): void
    {
        file_put_contents('dump/manufacturers.csv', '');

        $this->client->request('GET', '/downloads/manufacturers');

        self::assertResponseStatusCodeSame(200);

        unlink('dump/manufacturers.csv');
    }
}
