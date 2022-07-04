<?php

declare(strict_types=1);

namespace Tests\Functional\Controller\Database;

use App\Entity\Manufacturer;
use App\Entity\Tag;
use App\Factory\EngineModelFactory;
use App\Factory\ManufacturerFactory;
use App\Factory\TagFactory;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Uid\Uuid;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

final class EngineModelControllerTest extends WebTestCase
{
    use Factories;
    use ResetDatabase;

    private KernelBrowser $client;

    public function setUp(): void
    {
        $this->client = self::createClient();
    }

    /**
     * @testdox Accessing "/database/engine-models" returns an HTTP 200 response.
     */
    public function testList(): void
    {
        $this->client->request('GET', '/database/engine-models');

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('h1', 'Engine models');
    }

    /**
     * @testdox Accessing "/database/engine-models" with filters returns an HTTP 200 response.
     */
    public function testListWithFilters(): void
    {
        /** @var Proxy<Manufacturer> $manufacturer */
        $manufacturer = ManufacturerFactory::createOne();
        $manufacturer
            ->forceSet('id', Uuid::fromRfc4122('0b3c775e-79dd-4ccf-8c17-0b4759d0dd68'))
            ->save();

        /** @var Proxy<Tag> $tag */
        $tag = TagFactory::createOne();
        $tag
            ->forceSet('id', Uuid::fromRfc4122('c0faf2c2-8f6f-4fcb-a92c-52f7663e3757'))
            ->save();

        $this->client->request('GET', '/database/engine-models');
        $this->client->submitForm('Apply', [
            'filters[engineFamily]' => 'turbofan',
            'filters[manufacturer]' => '0b3c775e-79dd-4ccf-8c17-0b4759d0dd68',
            'filters[name]' => 'LTS101-650B-1A',
            'filters[tags]' => ['c0faf2c2-8f6f-4fcb-a92c-52f7663e3757'],
        ], 'GET');

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('h1', 'Engine models');
    }

    /**
     * @testdox Accessing "/database/engine-models" with an invalid page returns an HTTP 404 response.
     */
    public function testListWithInvalidPage(): void
    {
        $this->client->request('GET', '/database/engine-models', ['page' => 10]);

        self::assertResponseStatusCodeSame(404);
    }

    /**
     * @testdox Accessing "/database/engine-models/{slug}" returns an HTTP 200 response.
     */
    public function testRead(): void
    {
        EngineModelFactory::createOne(['name' => 'CFM56-3B1']);

        $this->client->request('GET', '/database/engine-models/cfm56-3b1');

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('h1', 'CFM56-3B1');
    }

    /**
     * @testdox Accessing "/database/engine-models/{slug}" with an invalid slug returns an HTTP 404 response.
     */
    public function testReadWithInvalidSlug(): void
    {
        $this->client->request('GET', '/database/engine-models/invalid-slug');

        self::assertResponseStatusCodeSame(404);
    }
}
