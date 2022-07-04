<?php

declare(strict_types=1);

namespace Tests\Functional\Controller\Admin;

use App\Entity\PropertyGroup;
use App\Entity\User;
use App\Factory\PropertyGroupFactory;
use App\Factory\UserFactory;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Uid\Uuid;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

final class PropertyGroupControllerTest extends WebTestCase
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
     * @testdox Accessing "/admin/property-groups/{id}/clone" returns an HTTP 200 response.
     */
    public function testClone(): void
    {
        /** @var Proxy<PropertyGroup> $propertyGroup */
        $propertyGroup = PropertyGroupFactory::createOne();
        $propertyGroup
            ->forceSet('id', Uuid::fromRfc4122('76a99c38-590b-4dfe-a432-c95d3e7fb35e'))
            ->save();

        $this->client->request('GET', '/admin/property-groups/76a99c38-590b-4dfe-a432-c95d3e7fb35e/clone');

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('h5', 'New property group');
    }

    /**
     * @testdox Accessing "/admin/property-groups/{id}/clone" with an invalid ID returns an HTTP 404 response.
     */
    public function testCloneWithInvalidId(): void
    {
        $this->client->request('GET', '/admin/property-groups/c2daa85a-1d94-4e73-99cb-3b097fdf6472/clone');

        self::assertResponseStatusCodeSame(404);
    }

    /**
     * @testdox Accessing "/admin/property-groups/create" returns an HTTP 200 response.
     */
    public function testCreate(): void
    {
        $this->client->request('GET', '/admin/property-groups/create');

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('h5', 'New property group');
    }

    /**
     * @testdox Submitting "/admin/property-groups/create" creates the property group.
     */
    public function testCreateSubmit(): void
    {
        $this->client->request('GET', '/admin/property-groups/create');
        $this->client->submitForm('Save', [
            'property_group[name]' => 'Dimensions',
        ], serverParameters: ['HTTP_REFERER' => '/admin/property-groups']);
        $this->client->followRedirect();

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('div', 'The property group has been created.');
    }

    /**
     * @testdox Accessing "/admin/property-groups/{id}/delete" returns an HTTP 200 response.
     */
    public function testDelete(): void
    {
        /** @var Proxy<PropertyGroup> $propertyGroup */
        $propertyGroup = PropertyGroupFactory::createOne();
        $propertyGroup
            ->forceSet('id', Uuid::fromRfc4122('0c7a35e8-4760-402b-baf2-fed0123a324e'))
            ->save();

        $this->client->request('GET', '/admin/property-groups/0c7a35e8-4760-402b-baf2-fed0123a324e/delete');

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('h5', 'Delete the property group');
    }

    /**
     * @testdox Accessing "/admin/property-groups/{id}/delete" with an invalid ID returns an HTTP 404 response.
     */
    public function testDeleteWithInvalidId(): void
    {
        $this->client->request('GET', '/admin/property-groups/e2f3cc0b-8603-42ce-b8d9-53baea870d4f/delete');

        self::assertResponseStatusCodeSame(404);
    }

    /**
     * @testdox Submitting "/admin/property-groups/{id}/delete" deletes the property group.
     */
    public function testDeleteSubmit(): void
    {
        /** @var Proxy<PropertyGroup> $propertyGroup */
        $propertyGroup = PropertyGroupFactory::createOne();
        $propertyGroup
            ->forceSet('id', Uuid::fromRfc4122('831d98cc-72ae-4284-a2aa-d0e9688bb1e0'))
            ->save();

        $this->client->request('GET', '/admin/property-groups/831d98cc-72ae-4284-a2aa-d0e9688bb1e0/delete');
        $this->client->submitForm('Delete', serverParameters: ['HTTP_REFERER' => '/admin/property-groups']);
        $this->client->followRedirect();

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('div', 'The property group has been deleted.');
    }

    /**
     * @testdox Accessing "/admin/property-groups" returns an HTTP 200 response.
     */
    public function testList(): void
    {
        $this->client->request('GET', '/admin/property-groups');

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('h1', 'Property groups');
    }

    /**
     * @testdox Accessing "/admin/property-groups" with filters returns an HTTP 200 response.
     */
    public function testListWithFilters(): void
    {
        $this->client->request('GET', '/admin/property-groups');
        $this->client->submitForm('Apply', [
            'filters[name]' => 'Dimensions',
        ], 'GET');

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('h1', 'Property groups');
    }

    /**
     * @testdox Accessing "/admin/property-groups" with an invalid page returns an HTTP 404 response.
     */
    public function testListWithInvalidPage(): void
    {
        $this->client->request('GET', '/admin/property-groups', ['page' => 10]);

        self::assertResponseStatusCodeSame(404);
    }

    /**
     * @testdox Accessing "/admin/property-groups/{id}/update" returns an HTTP 200 response.
     */
    public function testUpdate(): void
    {
        /** @var Proxy<PropertyGroup> $propertyGroup */
        $propertyGroup = PropertyGroupFactory::createOne(['name' => 'Weights']);
        $propertyGroup
            ->forceSet('id', Uuid::fromRfc4122('ddce5410-a9e4-4037-9eed-9eee3419020c'))
            ->save();

        $this->client->request('GET', '/admin/property-groups/ddce5410-a9e4-4037-9eed-9eee3419020c/update');

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('h5', 'Weights');
    }

    /**
     * @testdox Accessing "/admin/property-groups/{id}/update" with an invalid ID returns an HTTP 404 response.
     */
    public function testUpdateWithInvalidId(): void
    {
        $this->client->request('GET', '/admin/property-groups/c1f5ad3e-4267-45ea-9993-e4ac8f1b94dc/update');

        self::assertResponseStatusCodeSame(404);
    }

    /**
     * @testdox Submitting "/admin/property-groups/{id}/update" updates the property group.
     */
    public function testUpdateSubmit(): void
    {
        /** @var Proxy<PropertyGroup> $propertyGroup */
        $propertyGroup = PropertyGroupFactory::createOne();
        $propertyGroup
            ->forceSet('id', Uuid::fromRfc4122('36910b5c-a5fe-42ea-84a5-bd6f3613f5cf'))
            ->save();

        $this->client->request('GET', '/admin/property-groups/36910b5c-a5fe-42ea-84a5-bd6f3613f5cf/update');
        $this->client->submitForm('Save', [
            'property_group[name]' => 'Speed limits',
        ], serverParameters: ['HTTP_REFERER' => '/admin/property-groups']);
        $this->client->followRedirect();

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('div', 'The property group has been updated.');
    }
}
