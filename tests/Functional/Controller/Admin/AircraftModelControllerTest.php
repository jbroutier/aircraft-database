<?php

declare(strict_types=1);

namespace Tests\Functional\Controller\Admin;

use App\Entity\AircraftModel;
use App\Entity\AircraftType;
use App\Entity\Manufacturer;
use App\Entity\Tag;
use App\Entity\User;
use App\Factory\AircraftModelFactory;
use App\Factory\AircraftTypeFactory;
use App\Factory\ManufacturerFactory;
use App\Factory\PropertyFactory;
use App\Factory\PropertyValueFactory;
use App\Factory\TagFactory;
use App\Factory\UserFactory;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Uid\Uuid;
use Zenstruck\Foundry\Proxy;
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

        /** @var Proxy<User> $user */
        $user = UserFactory::createOne(['roles' => ['ROLE_ADMIN']]);
        $this->client->loginUser($user->object());
    }

    /**
     * @testdox Accessing "/admin/aircraft-models/{id}/autofill" returns an HTTP 200 response.
     */
    public function testAutofill(): void
    {
        /** @var Proxy<AircraftModel> $aircraftModel */
        $aircraftModel = AircraftModelFactory::createOne([
            'name' => 'A350-1041',
            'aircraftType' => AircraftTypeFactory::createOne([
                'propertyValues' => PropertyValueFactory::createMany(1, [
                    'property' => PropertyFactory::createOne(),
                ]),
            ]),
        ]);

        $aircraftModel
            ->forceSet('id', Uuid::fromRfc4122('1beb6d1f-f964-46f4-8edc-ef62fa0ef513'))
            ->save();

        $this->client->request('GET', '/admin/aircraft-models/1beb6d1f-f964-46f4-8edc-ef62fa0ef513/autofill');

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('h5', 'A350-1041');
    }

    /**
     * @testdox Accessing "/admin/aircraft-models/{id}/autofill" with an invalid ID returns an HTTP 404 response.
     */
    public function testAutofillWithInvalidId(): void
    {
        $this->client->request('GET', '/admin/aircraft-models/d370ba51-5a3e-4438-96d2-2841039db8f2/autofill');

        self::assertResponseStatusCodeSame(404);
    }

    /**
     * @testdox Accessing "/admin/aircraft-models/{id}/clone" returns an HTTP 200 response.
     */
    public function testClone(): void
    {
        /** @var Proxy<AircraftModel> $aircraftModel */
        $aircraftModel = AircraftModelFactory::createOne();
        $aircraftModel
            ->forceSet('id', Uuid::fromRfc4122('319687ca-c8d8-40e4-8c3f-038ea1904ed4'))
            ->save();

        $this->client->request('GET', '/admin/aircraft-models/319687ca-c8d8-40e4-8c3f-038ea1904ed4/clone');

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('h5', 'New aircraft model');
    }

    /**
     * @testdox Accessing "/admin/aircraft-models/{id}/clone" with an invalid ID returns an HTTP 404 response.
     */
    public function testCloneWithInvalidId(): void
    {
        $this->client->request('GET', '/admin/aircraft-models/50067397-1049-4dda-9c7f-c6d2c08d4fcd/clone');

        self::assertResponseStatusCodeSame(404);
    }

    /**
     * @testdox Accessing "/admin/aircraft-models/create" returns an HTTP 200 response.
     */
    public function testCreate(): void
    {
        $this->client->request('GET', '/admin/aircraft-models/create');

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('h5', 'New aircraft model');
    }

    /**
     * @testdox Submitting "/admin/aircraft-models/create" creates the aircraft model.
     */
    public function testCreateSubmit(): void
    {
        /** @var Proxy<AircraftType> $aircraftType */
        $aircraftType = AircraftTypeFactory::createOne();
        $aircraftType
            ->forceSet('id', Uuid::fromRfc4122('f90ebae5-65a9-4ec0-a7bf-eb01639d01ae'))
            ->save();

        /** @var Proxy<Manufacturer> $manufacturer */
        $manufacturer = ManufacturerFactory::createOne();
        $manufacturer
            ->forceSet('id', Uuid::fromRfc4122('e62e55ce-11a6-46b2-9b2f-4f306cb2c1f8'))
            ->save();

        $this->client->request('GET', '/admin/aircraft-models/create');
        $this->client->submitForm('Save', [
            'aircraft_model[aircraftFamily]' => 'airplane',
            'aircraft_model[aircraftType]' => 'f90ebae5-65a9-4ec0-a7bf-eb01639d01ae',
            'aircraft_model[engineCount]' => '4',
            'aircraft_model[engineFamily]' => 'turboprop',
            'aircraft_model[manufacturer]' => 'e62e55ce-11a6-46b2-9b2f-4f306cb2c1f8',
            'aircraft_model[name]' => 'A400M-180 Atlas',
            'aircraft_model[slug]' => 'a400m-180-atlas',
        ], serverParameters: ['HTTP_REFERER' => '/admin/aircraft-models']);
        $this->client->followRedirect();

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('div', 'The aircraft model has been created.');
    }

    /**
     * @testdox Accessing "/admin/aircraft-models/{id}/delete" returns an HTTP 200 response.
     */
    public function testDelete(): void
    {
        /** @var Proxy<AircraftModel> $aircraftModel */
        $aircraftModel = AircraftModelFactory::createOne();
        $aircraftModel
            ->forceSet('id', Uuid::fromRfc4122('89d9365e-9168-4d90-b974-2766593a6860'))
            ->save();

        $this->client->request('GET', '/admin/aircraft-models/89d9365e-9168-4d90-b974-2766593a6860/delete');

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('h5', 'Delete the aircraft model');
    }

    /**
     * @testdox Accessing "/admin/aircraft-models/{id}/delete" with an invalid ID returns an HTTP 404 response.
     */
    public function testDeleteWithInvalidId(): void
    {
        $this->client->request('GET', '/admin/aircraft-models/ea13af26-74fd-4c5c-a76e-eed9a196bd80/delete');

        self::assertResponseStatusCodeSame(404);
    }

    /**
     * @testdox Submitting "/admin/aircraft-models/{id}/delete" deletes the aircraft model.
     */
    public function testDeleteSubmit(): void
    {
        /** @var Proxy<AircraftModel> $aircraftModel */
        $aircraftModel = AircraftModelFactory::createOne();
        $aircraftModel
            ->forceSet('id', Uuid::fromRfc4122('273247df-cc34-4340-b052-81d1cbc069b7'))
            ->save();

        $this->client->request('GET', '/admin/aircraft-models/273247df-cc34-4340-b052-81d1cbc069b7/delete');
        $this->client->submitForm('Delete', serverParameters: ['HTTP_REFERER' => '/admin/aircraft-models']);
        $this->client->followRedirect();

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('div', 'The aircraft model has been deleted.');
    }

    /**
     * @testdox Accessing "/admin/aircraft-models" returns an HTTP 200 response.
     */
    public function testList(): void
    {
        $this->client->request('GET', '/admin/aircraft-models');

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('h1', 'Aircraft models');
    }

    /**
     * @testdox Accessing "/admin/aircraft-models" with filters returns an HTTP 200 response.
     */
    public function testListWithFilters(): void
    {
        /** @var Proxy<AircraftType> $aircraftType */
        $aircraftType = AircraftTypeFactory::createOne();
        $aircraftType
            ->forceSet('id', Uuid::fromRfc4122('448a7d4c-a61d-4210-96e2-6b30734de572'))
            ->save();

        /** @var Proxy<Manufacturer> $manufacturer */
        $manufacturer = ManufacturerFactory::createOne();
        $manufacturer
            ->forceSet('id', Uuid::fromRfc4122('0b8cec48-f7ab-4e8a-91e4-d27eee84e2c6'))
            ->save();

        /** @var Proxy<Tag> $tag */
        $tag = TagFactory::createOne();
        $tag
            ->forceSet('id', Uuid::fromRfc4122('87747920-8137-4445-b70b-65724b4912f8'))
            ->save();

        $this->client->request('GET', '/admin/aircraft-models');
        $this->client->submitForm('Apply', [
            'filters[aircraftType]' => '448a7d4c-a61d-4210-96e2-6b30734de572',
            'filters[aircraftFamily]' => 'helicopter',
            'filters[engineFamily]' => 'turboshaft',
            'filters[manufacturer]' => '0b8cec48-f7ab-4e8a-91e4-d27eee84e2c6',
            'filters[name]' => 'EC725 Caracal',
            'filters[tags]' => ['87747920-8137-4445-b70b-65724b4912f8'],
        ], 'GET');

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('h1', 'Aircraft models');
    }

    /**
     * @testdox Accessing "/admin/aircraft-models" with an invalid page returns an HTTP 404 response.
     */
    public function testListWithInvalidPage(): void
    {
        $this->client->request('GET', '/admin/aircraft-models', ['page' => 10]);

        self::assertResponseStatusCodeSame(404);
    }

    /**
     * @testdox Accessing "/admin/aircraft-models/{id}/update" returns an HTTP 200 response.
     */
    public function testUpdate(): void
    {
        /** @var Proxy<AircraftModel> $aircraftModel */
        $aircraftModel = AircraftModelFactory::createOne(['name' => '737-8AS']);
        $aircraftModel
            ->forceSet('id', Uuid::fromRfc4122('05613cf2-5334-4703-b260-d25776e48c9e'))
            ->save();

        $this->client->request('GET', '/admin/aircraft-models/05613cf2-5334-4703-b260-d25776e48c9e/update');

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('h5', '737-8AS');
    }

    /**
     * @testdox Accessing "/admin/aircraft-models/{id}/update" with an invalid ID returns an HTTP 404 response.
     */
    public function testUpdateWithInvalidId(): void
    {
        $this->client->request('GET', '/admin/aircraft-models/922140aa-f2ac-4e99-9377-1ad0a1bea4c1/update');

        self::assertResponseStatusCodeSame(404);
    }

    /**
     * @testdox Submitting "/admin/aircraft-models/{id}/update" updates the aircraft model.
     */
    public function testUpdateSubmit(): void
    {
        /** @var Proxy<AircraftType> $aircraftType */
        $aircraftType = AircraftTypeFactory::createOne();
        $aircraftType
            ->forceSet('id', Uuid::fromRfc4122('e291c78a-3e90-48fa-846e-0402d1607e06'))
            ->save();

        /** @var Proxy<Manufacturer> $manufacturer */
        $manufacturer = ManufacturerFactory::createOne();
        $manufacturer
            ->forceSet('id', Uuid::fromRfc4122('26ce0b3e-3afa-4b6b-ac96-40d321022863'))
            ->save();

        /** @var Proxy<AircraftModel> $aircraftModel */
        $aircraftModel = AircraftModelFactory::createOne();
        $aircraftModel
            ->forceSet('id', Uuid::fromRfc4122('679f425a-c20f-445a-ba38-02f84e755594'))
            ->save();

        $this->client->request('GET', '/admin/aircraft-models/679f425a-c20f-445a-ba38-02f84e755594/update');
        $this->client->submitForm('Save', [
            'aircraft_model[aircraftFamily]' => 'airplane',
            'aircraft_model[aircraftType]' => 'e291c78a-3e90-48fa-846e-0402d1607e06',
            'aircraft_model[engineCount]' => '2',
            'aircraft_model[engineFamily]' => 'turbofan',
            'aircraft_model[manufacturer]' => '26ce0b3e-3afa-4b6b-ac96-40d321022863',
            'aircraft_model[name]' => '737-8B6',
        ], serverParameters: ['HTTP_REFERER' => '/admin/aircraft-models']);
        $this->client->followRedirect();

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('div', 'The aircraft model has been updated.');
    }
}
