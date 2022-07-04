<?php

declare(strict_types=1);

namespace Tests\Functional\Controller\Database;

use App\Entity\Tag;
use App\Factory\ManufacturerFactory;
use App\Factory\TagFactory;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Uid\Uuid;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

final class ManufacturerControllerTest extends WebTestCase
{
    use Factories;
    use ResetDatabase;

    private KernelBrowser $client;

    public function setUp(): void
    {
        $this->client = self::createClient();
    }

    /**
     * @testdox Accessing "/database/manufacturers" returns an HTTP 200 response.
     */
    public function testList(): void
    {
        $this->client->request('GET', '/database/manufacturers');

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('h1', 'Manufacturers');
    }

    /**
     * @testdox Accessing "/database/manufacturers" with filters returns an HTTP 200 response.
     */
    public function testListWithFilters(): void
    {
        /** @var Proxy<Tag> $tag */
        $tag = TagFactory::createOne();
        $tag
            ->forceSet('id', Uuid::fromRfc4122('6aee89e9-d23c-4225-96c9-406c5cbb4049'))
            ->save();

        $this->client->request('GET', '/database/manufacturers');
        $this->client->submitForm('Apply', [
            'filters[country]' => 'US',
            'filters[name]' => 'Boeing',
            'filters[tags]' => ['6aee89e9-d23c-4225-96c9-406c5cbb4049'],
        ], 'GET');

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('h1', 'Manufacturers');
    }

    /**
     * @testdox Accessing "/database/manufacturers" with an invalid page returns an HTTP 404 response.
     */
    public function testListWithInvalidPage(): void
    {
        $this->client->request('GET', '/database/manufacturers', ['page' => 10]);

        self::assertResponseStatusCodeSame(404);
    }

    /**
     * @testdox Accessing "/database/manufacturers/{slug}" returns an HTTP 200 response.
     */
    public function testRead(): void
    {
        ManufacturerFactory::createOne(['name' => 'Boeing']);

        $this->client->request('GET', '/database/manufacturers/boeing');

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('h1', 'Boeing');
    }

    /**
     * @testdox Accessing "/database/manufacturers/{slug}" with an invalid slug returns an HTTP 404 response.
     */
    public function testReadWithInvalidSlug(): void
    {
        $this->client->request('GET', '/database/manufacturers/invalid-slug');

        self::assertResponseStatusCodeSame(404);
    }
}
