<?php

declare(strict_types=1);

namespace Tests\Functional\Controller\Admin;

use App\Entity\Manufacturer;
use App\Entity\Tag;
use App\Entity\User;
use App\Factory\ManufacturerFactory;
use App\Factory\TagFactory;
use App\Factory\UserFactory;
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

        /** @var Proxy<User> $user */
        $user = UserFactory::createOne(['roles' => ['ROLE_ADMIN']]);
        $this->client->loginUser($user->object());
    }

    /**
     * @testdox Accessing "/admin/manufacturers/{id}/clone" returns an HTTP 200 response.
     */
    public function testClone(): void
    {
        /** @var Proxy<Manufacturer> $manufacturer */
        $manufacturer = ManufacturerFactory::createOne();
        $manufacturer
            ->forceSet('id', Uuid::fromRfc4122('7cdc7f34-7a3d-4a81-adc3-157f6d15807b'))
            ->save();

        $this->client->request('GET', '/admin/manufacturers/7cdc7f34-7a3d-4a81-adc3-157f6d15807b/clone');

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('h5', 'New manufacturer');
    }

    /**
     * @testdox Accessing "/admin/manufacturers/{id}/clone" with an invalid ID returns an HTTP 404 response.
     */
    public function testCloneWithInvalidId(): void
    {
        $this->client->request('GET', '/admin/manufacturers/8014db5a-0725-40b7-965e-5db129fb5175/clone');

        self::assertResponseStatusCodeSame(404);
    }

    /**
     * @testdox Accessing "/admin/manufacturers/create" returns an HTTP 200 response.
     */
    public function testCreate(): void
    {
        $this->client->request('GET', '/admin/manufacturers/create');

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('h5', 'New manufacturer');
    }

    /**
     * @testdox Submitting "/admin/manufacturers/create" creates the manufacturer.
     */
    public function testCreateSubmit(): void
    {
        $this->client->request('GET', '/admin/manufacturers/create');
        $this->client->submitForm('Save', [
            'manufacturer[name]' => 'Boeing',
            'manufacturer[slug]' => 'boeing',
        ], serverParameters: ['HTTP_REFERER' => '/admin/manufacturers']);
        $this->client->followRedirect();

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('div', 'The manufacturer has been created.');
    }

    /**
     * @testdox Accessing "/admin/manufacturers/{id}/delete" returns an HTTP 200 response.
     */
    public function testDelete(): void
    {
        /** @var Proxy<Manufacturer> $manufacturer */
        $manufacturer = ManufacturerFactory::createOne();
        $manufacturer
            ->forceSet('id', Uuid::fromRfc4122('4d557478-04e4-4aeb-b8a2-73f896f247ab'))
            ->save();

        $this->client->request('GET', '/admin/manufacturers/4d557478-04e4-4aeb-b8a2-73f896f247ab/delete');

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('h5', 'Delete the manufacturer');
    }

    /**
     * @testdox Accessing "/admin/manufacturers/{id}/delete" with an invalid ID returns an HTTP 404 response.
     */
    public function testDeleteWithInvalidId(): void
    {
        $this->client->request('GET', '/admin/manufacturers/7d68494a-11a2-4222-a4eb-7d182b1facb1/delete');

        self::assertResponseStatusCodeSame(404);
    }

    /**
     * @testdox Submitting "/admin/manufacturers/{id}/delete" deletes the manufacturer.
     */
    public function testDeleteSubmit(): void
    {
        /** @var Proxy<Manufacturer> $manufacturer */
        $manufacturer = ManufacturerFactory::createOne();
        $manufacturer
            ->forceSet('id', Uuid::fromRfc4122('d8166446-924f-4df0-81d7-bef2082a67de'))
            ->save();

        $this->client->request('GET', '/admin/manufacturers/d8166446-924f-4df0-81d7-bef2082a67de/delete');
        $this->client->submitForm('Delete', serverParameters: ['HTTP_REFERER' => '/admin/manufacturers']);
        $this->client->followRedirect();

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('div', 'The manufacturer has been deleted.');
    }

    /**
     * @testdox Accessing "/admin/manufacturers" returns an HTTP 200 response.
     */
    public function testList(): void
    {
        $this->client->request('GET', '/admin/manufacturers');

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('h1', 'Manufacturers');
    }

    /**
     * @testdox Accessing "/admin/manufacturers" with filters returns an HTTP 200 response.
     */
    public function testListWithFilters(): void
    {
        /** @var Proxy<Tag> $tag */
        $tag = TagFactory::createOne();
        $tag
            ->forceSet('id', Uuid::fromRfc4122('ad2c27d9-0357-4995-87be-51c01ceee24d'))
            ->save();

        $this->client->request('GET', '/admin/manufacturers');
        $this->client->submitForm('Apply', [
            'filters[country]' => 'US',
            'filters[name]' => 'Boeing',
            'filters[tags]' => ['ad2c27d9-0357-4995-87be-51c01ceee24d'],
        ], 'GET');

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('h1', 'Manufacturers');
    }

    /**
     * @testdox Accessing "/admin/manufacturers" with an invalid page returns an HTTP 404 response.
     */
    public function testListWithInvalidPage(): void
    {
        $this->client->request('GET', '/admin/manufacturers', ['page' => 10]);

        self::assertResponseStatusCodeSame(404);
    }

    /**
     * @testdox Accessing "/admin/manufacturers/{id}/update" returns an HTTP 200 response.
     */
    public function testUpdate(): void
    {
        /** @var Proxy<Manufacturer> $manufacturer */
        $manufacturer = ManufacturerFactory::createOne(['name' => 'Airbus']);
        $manufacturer
            ->forceSet('id', Uuid::fromRfc4122('cea2a042-293d-44c9-9035-4ef81d1073e8'))
            ->save();

        $this->client->request('GET', '/admin/manufacturers/cea2a042-293d-44c9-9035-4ef81d1073e8/update');

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('h5', 'Airbus');
    }

    /**
     * @testdox Accessing "/admin/manufacturers/{id}/update" with an invalid ID returns an HTTP 404 response.
     */
    public function testUpdateWithInvalidId(): void
    {
        $this->client->request('GET', '/admin/manufacturers/bc98d1e8-865f-4aad-80cf-74ab61fb16e1/update');

        self::assertResponseStatusCodeSame(404);
    }

    /**
     * @testdox Submitting "/admin/manufacturers/{id}/update" updates the manufacturer.
     */
    public function testUpdateSubmit(): void
    {
        /** @var Proxy<Manufacturer> $manufacturer */
        $manufacturer = ManufacturerFactory::createOne(['name' => 'Airbus']);
        $manufacturer
            ->forceSet('id', Uuid::fromRfc4122('eef34643-aad0-4fb0-bf06-048b871cb3d3'))
            ->save();

        $this->client->request('GET', '/admin/manufacturers/eef34643-aad0-4fb0-bf06-048b871cb3d3/update');
        $this->client->submitForm('Save', [
            'manufacturer[name]' => 'Airbus Defence and Space',
        ], serverParameters: ['HTTP_REFERER' => '/admin/manufacturers']);
        $this->client->followRedirect();

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('div', 'The manufacturer has been updated.');
    }
}
