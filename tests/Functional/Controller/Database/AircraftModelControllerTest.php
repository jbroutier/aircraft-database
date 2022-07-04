<?php

declare(strict_types=1);

namespace Tests\Functional\Controller\Database;

use App\Factory\AircraftModelFactory;
use App\Factory\AircraftTypeFactory;
use App\Factory\ManufacturerFactory;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

final class AircraftModelControllerTest extends WebTestCase
{
    use Factories;
    use ResetDatabase;

    private KernelBrowser $client;

    public function setUp(): void
    {
        $this->client = self::createClient();
    }

    /**
     * @testdox Accessing "/database/aircraft-models/{slug}" returns an HTTP 200 response.
     */
    public function testRead(): void
    {
        AircraftModelFactory::createOne([
            'name' => 'A321-251NX',
            'aircraftType' => AircraftTypeFactory::createOne([
                'name' => 'A321neo',
                'manufacturer' => ManufacturerFactory::createOne([
                    'name' => 'Airbus',
                ]),
            ]),
        ]);

        $this->client->request('GET', '/database/aircraft-models/a321-251nx');

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('h1', 'A321-251NX');
    }

    /**
     * @testdox Accessing '/database/aircraft-models/{slug}' with an invalid slug returns an HTTP 404 response.
     */
    public function testReadWithInvalidSlug(): void
    {
        $this->client->request('GET', '/database/aircraft-models/invalid-slug');

        self::assertResponseStatusCodeSame(404);
    }
}
