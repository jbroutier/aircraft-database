<?php

declare(strict_types=1);

namespace Tests\Functional\Controller\Database;

use App\Entity\Manufacturer;
use App\Entity\Tag;
use App\Factory\AircraftTypeFactory;
use App\Factory\ManufacturerFactory;
use App\Factory\TagFactory;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Uid\Uuid;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

final class AircraftTypeControllerTest extends WebTestCase
{
    use Factories;
    use ResetDatabase;

    private KernelBrowser $client;

    public function setUp(): void
    {
        $this->client = self::createClient();
    }

    /**
     * @testdox Accessing "/database/aircraft-types" returns an HTTP 200 response.
     */
    public function testList(): void
    {
        $this->client->request('GET', '/database/aircraft-types');

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('h1', 'Aircraft types');
    }

    /**
     * @testdox Accessing "/database/aircraft-types" with filters returns an HTTP 200 response.
     */
    public function testListWithFilters(): void
    {
        /** @var Proxy<Manufacturer> $manufacturer */
        $manufacturer = ManufacturerFactory::createOne();
        $manufacturer
            ->forceSet('id', Uuid::fromRfc4122('5f45ac8a-9d22-4f5e-81e6-fb6adc314ba5'))
            ->save();

        /** @var Proxy<Tag> $tag */
        $tag = TagFactory::createOne();
        $tag
            ->forceSet('id', Uuid::fromRfc4122('66f91aaa-f2de-4143-84ba-e93dcd5f8464'))
            ->save();

        $this->client->request('GET', '/database/aircraft-types');
        $this->client->submitForm('Apply', [
            'filters[aircraftFamily]' => 'airplane',
            'filters[engineFamily]' => 'turbofan',
            'filters[iataCode]' => '320',
            'filters[icaoCode]' => 'A320',
            'filters[manufacturer]' => '5f45ac8a-9d22-4f5e-81e6-fb6adc314ba5',
            'filters[name]' => 'A300 B4-200',
            'filters[tags]' => ['66f91aaa-f2de-4143-84ba-e93dcd5f8464'],
        ], 'GET');

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('h1', 'Aircraft types');
    }

    /**
     * @testdox Accessing "/database/aircraft-types" with an invalid page returns an HTTP 404 response.
     */
    public function testListWithInvalidPage(): void
    {
        $this->client->request('GET', '/database/aircraft-types', ['page' => 10]);

        self::assertResponseStatusCodeSame(404);
    }

    /**
     * @testdox Accessing "/database/aircraft-types/{slug}" returns an HTTP 200 response.
     */
    public function testRead(): void
    {
        AircraftTypeFactory::createOne(['name' => 'A340-200']);

        $this->client->request('GET', '/database/aircraft-types/a340-200');

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('h1', 'A340-200');
    }

    /**
     * @testdox Accessing "/database/aircraft-types/{slug}" with an invalid slug returns an HTTP 404 response.
     */
    public function testReadWithInvalidSlug(): void
    {
        $this->client->request('GET', '/database/aircraft-types/invalid-slug');

        self::assertResponseStatusCodeSame(404);
    }
}
