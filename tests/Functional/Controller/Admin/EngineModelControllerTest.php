<?php

declare(strict_types=1);

namespace Tests\Functional\Controller\Admin;

use App\Entity\EngineModel;
use App\Entity\Manufacturer;
use App\Entity\Tag;
use App\Entity\User;
use App\Factory\EngineModelFactory;
use App\Factory\ManufacturerFactory;
use App\Factory\TagFactory;
use App\Factory\UserFactory;
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

        /** @var Proxy<User> $user */
        $user = UserFactory::createOne(['roles' => ['ROLE_ADMIN']]);
        $this->client->loginUser($user->object());
    }

    /**
     * @testdox Accessing "/admin/engine-models/{id}/clone" returns an HTTP 200 response.
     */
    public function testClone(): void
    {
        /** @var Proxy<EngineModel> $engineModel */
        $engineModel = EngineModelFactory::createOne();
        $engineModel
            ->forceSet('id', Uuid::fromRfc4122('813837c1-72b1-4bce-bac5-48fef46a20e6'))
            ->save();

        $this->client->request('GET', '/admin/engine-models/813837c1-72b1-4bce-bac5-48fef46a20e6/clone');

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('h5', 'New engine model');
    }

    /**
     * @testdox Accessing "/admin/engine-models/{id}/clone" with an invalid ID returns an HTTP 404 response.
     */
    public function testCloneWithInvalidId(): void
    {
        $this->client->request('GET', '/admin/engine-models/32ad05b5-3822-43bc-904c-31c0cb58ba2c/clone');

        self::assertResponseStatusCodeSame(404);
    }

    /**
     * @testdox Accessing "/admin/engine-models/create" returns an HTTP 200 response.
     */
    public function testCreate(): void
    {
        $this->client->request('GET', '/admin/engine-models/create');

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('h5', 'New engine model');
    }

    /**
     * @testdox Submitting "/admin/engine-models/create" creates the engine model.
     */
    public function testCreateSubmit(): void
    {
        /** @var Proxy<Manufacturer> $manufacturer */
        $manufacturer = ManufacturerFactory::createOne();
        $manufacturer
            ->forceSet('id', Uuid::fromRfc4122('bbe767cd-c780-4923-9050-01d054c40ea9'))
            ->save();

        $this->client->request('GET', '/admin/engine-models/create');
        $this->client->submitForm('Save', [
            'engine_model[engineFamily]' => 'piston',
            'engine_model[manufacturer]' => 'bbe767cd-c780-4923-9050-01d054c40ea9',
            'engine_model[name]' => 'TSIO-520-D',
            'engine_model[slug]' => 'tsio-520-d',
        ], serverParameters: ['HTTP_REFERER' => '/admin/engine-models']);
        $this->client->followRedirect();

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('div', 'The engine model has been created.');
    }

    /**
     * @testdox Accessing "/admin/engine-models/{id}/delete" returns an HTTP 200 response.
     */
    public function testDelete(): void
    {
        /** @var Proxy<EngineModel> $engineModel */
        $engineModel = EngineModelFactory::createOne();
        $engineModel
            ->forceSet('id', Uuid::fromRfc4122('eaf43575-7546-4095-8160-aa59be894fce'))
            ->save();

        $this->client->request('GET', '/admin/engine-models/eaf43575-7546-4095-8160-aa59be894fce/delete');

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('h5', 'Delete the engine model');
    }

    /**
     * @testdox Accessing "/admin/engine-models/{id}/delete" with an invalid ID returns an HTTP 404 response.
     */
    public function testDeleteWithInvalidId(): void
    {
        $this->client->request('GET', '/admin/engine-models/9d6f7d5a-9f2b-496d-9369-1c458280c2df/delete');

        self::assertResponseStatusCodeSame(404);
    }

    /**
     * @testdox Submitting "/admin/engine-models/{id}/delete" deletes the engine model.
     */
    public function testDeleteSubmit(): void
    {
        /** @var Proxy<EngineModel> $engineModel */
        $engineModel = EngineModelFactory::createOne();
        $engineModel
            ->forceSet('id', Uuid::fromRfc4122('91d7cdd7-6841-4da9-b994-e4ee21ad027a'))
            ->save();

        $this->client->request('GET', '/admin/engine-models/91d7cdd7-6841-4da9-b994-e4ee21ad027a/delete');
        $this->client->submitForm('Delete', serverParameters: ['HTTP_REFERER' => '/admin/engine-models']);
        $this->client->followRedirect();

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('div', 'The engine model has been deleted.');
    }

    /**
     * @testdox Accessing "/admin/engine-models" returns an HTTP 200 response.
     */
    public function testList(): void
    {
        $this->client->request('GET', '/admin/engine-models');

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('h1', 'Engine models');
    }

    /**
     * @testdox Accessing "/admin/engine-models" with filters returns an HTTP 200 response.
     */
    public function testListWithFilters(): void
    {
        /** @var Proxy<Manufacturer> $manufacturer */
        $manufacturer = ManufacturerFactory::createOne();
        $manufacturer
            ->forceSet('id', Uuid::fromRfc4122('b1399052-a67c-48dd-a1f8-07b02abf047d'))
            ->save();

        /** @var Proxy<Tag> $tag */
        $tag = TagFactory::createOne();
        $tag
            ->forceSet('id', Uuid::fromRfc4122('9f896c1c-a2f7-4db0-895f-3eaf0d788a1c'))
            ->save();

        $this->client->request('GET', '/admin/engine-models');
        $this->client->submitForm('Apply', [
            'filters[engineFamily]' => 'turbofan',
            'filters[manufacturer]' => 'b1399052-a67c-48dd-a1f8-07b02abf047d',
            'filters[name]' => 'CF34-8E6A1',
            'filters[tags]' => ['9f896c1c-a2f7-4db0-895f-3eaf0d788a1c'],
        ], 'GET');

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('h1', 'Engine models');
    }

    /**
     * @testdox Accessing "/admin/engine-models" with an invalid page returns an HTTP 404 response.
     */
    public function testListWithInvalidPage(): void
    {
        $this->client->request('GET', '/admin/engine-models', ['page' => 10]);

        self::assertResponseStatusCodeSame(404);
    }

    /**
     * @testdox Accessing "/admin/engine-models/{id}/update" returns an HTTP 200 response.
     */
    public function testUpdate(): void
    {
        /** @var Proxy<EngineModel> $engineModel */
        $engineModel = EngineModelFactory::createOne(['name' => 'Trent 1000-AE2']);
        $engineModel
            ->forceSet('id', Uuid::fromRfc4122('fa0eafc5-0653-4c76-949f-b6fb7fc70402'))
            ->save();

        $this->client->request('GET', '/admin/engine-models/fa0eafc5-0653-4c76-949f-b6fb7fc70402/update');

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('h5', 'Trent 1000-AE2');
    }

    /**
     * @testdox Accessing "/admin/engine-models/{id}/update" with an invalid ID returns an HTTP 404 response.
     */
    public function testUpdateWithInvalidId(): void
    {
        $this->client->request('GET', '/admin/engine-models/23f12d78-8a04-405d-aa57-6148d4d4d902/update');

        self::assertResponseStatusCodeSame(404);
    }

    /**
     * @testdox Submitting "/admin/engine-models/{id}/update" updates the engine model.
     */
    public function testUpdateSubmit(): void
    {
        /** @var Proxy<EngineModel> $engineModel */
        $engineModel = EngineModelFactory::createOne(['name' => 'TF34-GE-2']);
        $engineModel
            ->forceSet('id', Uuid::fromRfc4122('e57d7093-5688-4e43-9a5b-c6aeeb5bad90'))
            ->save();

        /** @var Proxy<Manufacturer> $manufacturer */
        $manufacturer = ManufacturerFactory::createOne();
        $manufacturer
            ->forceSet('id', Uuid::fromRfc4122('058b4a5a-0680-4034-b44b-ad34b288b983'))
            ->save();

        $this->client->request('GET', '/admin/engine-models/e57d7093-5688-4e43-9a5b-c6aeeb5bad90/update');
        $this->client->submitForm('Save', [
            'engine_model[engineFamily]' => 'turbofan',
            'engine_model[manufacturer]' => '058b4a5a-0680-4034-b44b-ad34b288b983',
            'engine_model[name]' => 'TF37-GE-1',
            'engine_model[slug]' => 'tf37-ge-1',
        ], serverParameters: ['HTTP_REFERER' => '/admin/engine-models']);
        $this->client->followRedirect();

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('div', 'The engine model has been updated.');
    }
}
