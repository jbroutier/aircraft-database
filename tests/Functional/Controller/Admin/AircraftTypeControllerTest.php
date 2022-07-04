<?php

declare(strict_types=1);

namespace Tests\Functional\Controller\Admin;

use App\Entity\AircraftType;
use App\Entity\Manufacturer;
use App\Entity\Tag;
use App\Entity\User;
use App\Factory\AircraftTypeFactory;
use App\Factory\ManufacturerFactory;
use App\Factory\TagFactory;
use App\Factory\UserFactory;
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

        /** @var Proxy<User> $user */
        $user = UserFactory::createOne(['roles' => ['ROLE_ADMIN']]);
        $this->client->loginUser($user->object());
    }

    /**
     * @testdox Accessing "/admin/aircraft-types/{id}/clone" returns an HTTP 200 response.
     */
    public function testClone(): void
    {
        /** @var Proxy<AircraftType> $aircraftType */
        $aircraftType = AircraftTypeFactory::createOne();
        $aircraftType
            ->forceSet('id', Uuid::fromRfc4122('96ed64c3-b9f7-4bb3-b6eb-6686e9958417'))
            ->save();

        $this->client->request('GET', '/admin/aircraft-types/96ed64c3-b9f7-4bb3-b6eb-6686e9958417/clone');

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('h5', 'New aircraft type');
    }

    /**
     * @testdox Accessing "/admin/aircraft-types/{id}/clone" with an invalid ID returns an HTTP 404 response.
     */
    public function testCloneWithInvalidId(): void
    {
        $this->client->request('GET', '/admin/aircraft-types/ed944c3f-7b1c-49ad-abf1-13b581a57eac/clone');

        self::assertResponseStatusCodeSame(404);
    }

    /**
     * @testdox Accessing "/admin/aircraft-types/create" returns an HTTP 200 response.
     */
    public function testCreate(): void
    {
        $this->client->request('GET', '/admin/aircraft-types/create');

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('h5', 'New aircraft type');
    }

    /**
     * @testdox Submitting "/admin/aircraft-types/create" creates the aircraft type.
     */
    public function testCreateSubmit(): void
    {
        /** @var Proxy<Manufacturer> $manufacturer */
        $manufacturer = ManufacturerFactory::createOne();
        $manufacturer
            ->forceSet('id', Uuid::fromRfc4122('9227fd20-d34a-4758-b1d9-3673c8611a80'))
            ->save();

        $this->client->request('GET', '/admin/aircraft-types/create');
        $this->client->submitForm('Save', [
            'aircraft_type[aircraftFamily]' => 'airplane',
            'aircraft_type[engineCount]' => '2',
            'aircraft_type[engineFamily]' => 'turbofan',
            'aircraft_type[manufacturer]' => '9227fd20-d34a-4758-b1d9-3673c8611a80',
            'aircraft_type[name]' => 'CRJ700',
            'aircraft_type[slug]' => 'crj700',
        ], serverParameters: ['HTTP_REFERER' => '/admin/aircraft-types']);
        $this->client->followRedirect();

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('div', 'The aircraft type has been created.');
    }

    /**
     * @testdox Accessing "/admin/aircraft-types/{id}/delete" returns an HTTP 200 response.
     */
    public function testDelete(): void
    {
        /** @var Proxy<AircraftType> $aircraftType */
        $aircraftType = AircraftTypeFactory::createOne();
        $aircraftType
            ->forceSet('id', Uuid::fromRfc4122('ae73a187-f966-4c2f-a02a-f7fe1d37f7c0'))
            ->save();

        $this->client->request('GET', '/admin/aircraft-types/ae73a187-f966-4c2f-a02a-f7fe1d37f7c0/delete');

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('h5', 'Delete the aircraft type');
    }

    /**
     * @testdox Accessing "/admin/aircraft-types/{id}/delete" with an invalid ID returns an HTTP 404 response.
     */
    public function testDeleteWithInvalidId(): void
    {
        $this->client->request('GET', '/admin/aircraft-types/7e7c8205-69ce-4b00-894b-341cf9ef5348/delete');

        self::assertResponseStatusCodeSame(404);
    }

    /**
     * @testdox Submitting "/admin/aircraft-types/{id}/delete" deletes the aircraft type.
     */
    public function testDeleteSubmit(): void
    {
        /** @var Proxy<AircraftType> $aircraftType */
        $aircraftType = AircraftTypeFactory::createOne();
        $aircraftType
            ->forceSet('id', Uuid::fromRfc4122('8853d961-71fc-4bb4-b5ef-b50e2896269d'))
            ->save();

        $this->client->request('GET', '/admin/aircraft-types/8853d961-71fc-4bb4-b5ef-b50e2896269d/delete');
        $this->client->submitForm('Delete', serverParameters: ['HTTP_REFERER' => '/admin/aircraft-types']);
        $this->client->followRedirect();

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('div', 'The aircraft type has been deleted.');
    }

    /**
     * @testdox Accessing "/admin/aircraft-types" returns an HTTP 200 response.
     */
    public function testList(): void
    {
        $this->client->request('GET', '/admin/aircraft-types');

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('h1', 'Aircraft types');
    }

    /**
     * @testdox Accessing "/admin/aircraft-types" with filters returns an HTTP 200 response.
     */
    public function testListWithFilters(): void
    {
        /** @var Proxy<Manufacturer> $manufacturer */
        $manufacturer = ManufacturerFactory::createOne();
        $manufacturer
            ->forceSet('id', Uuid::fromRfc4122('81f8f4c9-e1cf-4b7f-beb2-60a60a733609'))
            ->save();

        /** @var Proxy<Tag> $tag */
        $tag = TagFactory::createOne();
        $tag
            ->forceSet('id', Uuid::fromRfc4122('ddd92d0d-c27b-4c99-83e1-f2372eb32133'))
            ->save();

        $this->client->request('GET', '/admin/aircraft-types');
        $this->client->submitForm('Apply', [
            'filters[aircraftFamily]' => 'airplane',
            'filters[engineFamily]' => 'turboshaft',
            'filters[iataCode]' => '345',
            'filters[icaoCode]' => 'A345',
            'filters[manufacturer]' => '81f8f4c9-e1cf-4b7f-beb2-60a60a733609',
            'filters[name]' => 'A340-500',
            'filters[tags]' => ['ddd92d0d-c27b-4c99-83e1-f2372eb32133'],
        ], 'GET');

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('h1', 'Aircraft types');
    }

    /**
     * @testdox Accessing "/admin/aircraft-types" with an invalid page returns an HTTP 404 response.
     */
    public function testListWithInvalidPage(): void
    {
        $this->client->request('GET', '/admin/aircraft-types', ['page' => 10]);

        self::assertResponseStatusCodeSame(404);
    }

    /**
     * @testdox Accessing "/admin/aircraft-types/{id}/update" returns an HTTP 200 response.
     */
    public function testUpdate(): void
    {
        /** @var Proxy<AircraftType> $aircraftType */
        $aircraftType = AircraftTypeFactory::createOne(['name' => 'L-39 Albatros']);
        $aircraftType
            ->forceSet('id', Uuid::fromRfc4122('77ec645d-6257-4287-a6d5-18976b3a140b'))
            ->save();

        $this->client->request('GET', '/admin/aircraft-types/77ec645d-6257-4287-a6d5-18976b3a140b/update');

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('h5', 'L-39 Albatros');
    }

    /**
     * @testdox Accessing "/admin/aircraft-types/{id}/update" with an invalid ID returns an HTTP 404 response.
     */
    public function testUpdateWithInvalidId(): void
    {
        $this->client->request('GET', '/admin/aircraft-types/77d18157-dbb8-435e-b7ca-017495285b4b/update');

        self::assertResponseStatusCodeSame(404);
    }

    /**
     * @testdox Submitting "/admin/aircraft-types/{id}/update" updates the aircraft type.
     */
    public function testUpdateSubmit(): void
    {
        /** @var Proxy<AircraftType> $aircraftType */
        $aircraftType = AircraftTypeFactory::createOne();
        $aircraftType
            ->forceSet('id', Uuid::fromRfc4122('5a968659-ca4d-41d6-86a4-f510b9b1abff'))
            ->save();

        /** @var Proxy<Manufacturer> $manufacturer */
        $manufacturer = ManufacturerFactory::createOne();
        $manufacturer
            ->forceSet('id', Uuid::fromRfc4122('92560f51-80b1-4c28-beb8-ec7b81a875cf'))
            ->save();

        $this->client->request('GET', '/admin/aircraft-types/5a968659-ca4d-41d6-86a4-f510b9b1abff/update');
        $this->client->submitForm('Save', [
            'aircraft_type[aircraftFamily]' => 'airplane',
            'aircraft_type[engineCount]' => '2',
            'aircraft_type[engineFamily]' => 'turbofan',
            'aircraft_type[manufacturer]' => '92560f51-80b1-4c28-beb8-ec7b81a875cf',
            'aircraft_type[name]' => 'CRJ900',
            'aircraft_type[slug]' => 'crj900',
        ], serverParameters: ['HTTP_REFERER' => '/admin/aircraft-types']);
        $this->client->followRedirect();

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('div', 'The aircraft type has been updated.');
    }
}
