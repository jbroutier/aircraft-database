<?php

declare(strict_types=1);

namespace Tests\Functional\Controller\Admin;

use App\Entity\Property;
use App\Entity\PropertyGroup;
use App\Entity\User;
use App\Factory\PropertyFactory;
use App\Factory\PropertyGroupFactory;
use App\Factory\UserFactory;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Uid\Uuid;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

final class PropertyControllerTest extends WebTestCase
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
     * @testdox Accessing "/admin/properties/{id}/clone" returns an HTTP 200 response.
     */
    public function testClone(): void
    {
        /** @var Proxy<Property> $property */
        $property = PropertyFactory::createOne();
        $property
            ->forceSet('id', Uuid::fromRfc4122('38fd50e1-3f9a-4e0b-82b4-30198eee3e42'))
            ->save();

        $this->client->request('GET', '/admin/properties/38fd50e1-3f9a-4e0b-82b4-30198eee3e42/clone');

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('h5', 'New property');
    }

    /**
     * @testdox Accessing "/admin/properties/{id}/clone" with an invalid ID returns an HTTP 404 response.
     */
    public function testCloneWithInvalidId(): void
    {
        $this->client->request('GET', '/admin/properties/b0b89bb1-68d9-46ef-9d80-12751dee7b33/clone');

        self::assertResponseStatusCodeSame(404);
    }

    /**
     * @testdox Accessing "/admin/properties/create" returns an HTTP 200 response.
     */
    public function testCreate(): void
    {
        $this->client->request('GET', '/admin/properties/create');

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('h5', 'New property');
    }

    /**
     * @testdox Submitting "/admin/properties/create" creates the property.
     */
    public function testCreateSubmit(): void
    {
        /** @var Proxy<PropertyGroup> $propertyGroup */
        $propertyGroup = PropertyGroupFactory::createOne();
        $propertyGroup
            ->forceSet('id', Uuid::fromRfc4122('78023791-b4cf-49a0-accb-4ad99c9c1bac'))
            ->save();

        $this->client->request('GET', '/admin/properties/create');
        $this->client->submitForm('Save', [
            'property[name]' => 'Fan diameter',
            'property[propertyGroup]' => '78023791-b4cf-49a0-accb-4ad99c9c1bac',
            'property[slug]' => 'fan-diameter',
            'property[type]' => 'float',
            'property[unit]' => 'metre',
        ], serverParameters: ['HTTP_REFERER' => '/admin/properties']);
        $this->client->followRedirect();

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('div', 'The property has been created.');
    }

    /**
     * @testdox Accessing "/admin/properties/{id}/delete" returns an HTTP 200 response.
     */
    public function testDelete(): void
    {
        /** @var Proxy<Property> $property */
        $property = PropertyFactory::createOne();
        $property
            ->forceSet('id', Uuid::fromRfc4122('8385d9a1-d38b-4848-b088-86e4ad2bd5e3'))
            ->save();

        $this->client->request('GET', '/admin/properties/8385d9a1-d38b-4848-b088-86e4ad2bd5e3/delete');

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('h5', 'Delete the property');
    }

    /**
     * @testdox Accessing "/admin/properties/{id}/delete" with an invalid ID returns an HTTP 404 response.
     */
    public function testDeleteWithInvalidId(): void
    {
        $this->client->request('GET', '/admin/properties/652d2298-01be-4510-a4b9-572fb8f4f8d8/delete');

        self::assertResponseStatusCodeSame(404);
    }

    /**
     * @testdox Submitting "/admin/properties/{id}/delete" deletes the property.
     */
    public function testDeleteSubmit(): void
    {
        /** @var Proxy<Property> $property */
        $property = PropertyFactory::createOne();
        $property
            ->forceSet('id', Uuid::fromRfc4122('df5e3ad1-a272-496d-8632-d964f3ce460d'))
            ->save();

        $this->client->request('GET', '/admin/properties/df5e3ad1-a272-496d-8632-d964f3ce460d/delete');
        $this->client->submitForm('Delete', serverParameters: ['HTTP_REFERER' => '/admin/properties']);
        $this->client->followRedirect();

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('div', 'The property has been deleted.');
    }

    /**
     * @testdox Accessing "/admin/properties" returns an HTTP 200 response.
     */
    public function testList(): void
    {
        $this->client->request('GET', '/admin/properties');

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('h1', 'Properties');
    }

    /**
     * @testdox Accessing "/admin/properties" with filters returns an HTTP 200 response.
     */
    public function testListWithFilters(): void
    {
        /** @var Proxy<PropertyGroup> $propertyGroup */
        $propertyGroup = PropertyGroupFactory::createOne();
        $propertyGroup
            ->forceSet('id', Uuid::fromRfc4122('7cd7ae31-812f-4f2a-8345-a4f3ae507ae0'))
            ->save();

        $this->client->request('GET', '/admin/properties');
        $this->client->submitForm('Apply', [
            'filters[name]' => 'Length',
            'filters[propertyGroup]' => '7cd7ae31-812f-4f2a-8345-a4f3ae507ae0',
            'filters[type]' => 'float',
        ], 'GET');

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('h1', 'Properties');
    }

    /**
     * @testdox Accessing "/admin/properties" with an invalid page returns an HTTP 404 response.
     */
    public function testListWithInvalidPage(): void
    {
        $this->client->request('GET', '/admin/properties', ['page' => 10]);

        self::assertResponseStatusCodeSame(404);
    }

    /**
     * @testdox Accessing "/admin/properties/{id}/update" returns an HTTP 200 response.
     */
    public function testUpdate(): void
    {
        /** @var Proxy<Property> $property */
        $property = PropertyFactory::createOne(['name' => 'Wing area']);
        $property
            ->forceSet('id', Uuid::fromRfc4122('09b37193-314f-4803-b0ff-398da57ace24'))
            ->save();

        $this->client->request('GET', '/admin/properties/09b37193-314f-4803-b0ff-398da57ace24/update');

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('h5', 'Wing area');
    }

    /**
     * @testdox Accessing "/admin/properties/{id}/update" with an invalid ID returns an HTTP 404 response.
     */
    public function testUpdateWithInvalidId(): void
    {
        $this->client->request('GET', '/admin/properties/159ca0aa-4e9a-415f-a21a-8cbf04fe3746/update');

        self::assertResponseStatusCodeSame(404);
    }

    /**
     * @testdox Submitting "/admin/properties/{id}/update" updates the property.
     */
    public function testUpdateSubmit(): void
    {
        /** @var Proxy<Property> $property */
        $property = PropertyFactory::createOne();
        $property
            ->forceSet('id', Uuid::fromRfc4122('b87d6b24-f225-4864-b755-baa64a36e470'))
            ->save();

        /** @var Proxy<PropertyGroup> $propertyGroup */
        $propertyGroup = PropertyGroupFactory::createOne();
        $propertyGroup
            ->forceSet('id', Uuid::fromRfc4122('ea29a133-b5f2-41d3-9d0e-976722678e78'))
            ->save();

        $this->client->request('GET', '/admin/properties/b87d6b24-f225-4864-b755-baa64a36e470/update');
        $this->client->submitForm('Save', [
            'property[name]' => 'Fan blades',
            'property[propertyGroup]' => 'ea29a133-b5f2-41d3-9d0e-976722678e78',
            'property[slug]' => 'fan-blades',
            'property[type]' => 'integer',
            'property[unit]' => '',
        ], serverParameters: ['HTTP_REFERER' => '/admin/properties']);
        $this->client->followRedirect();

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('div', 'The property has been updated.');
    }
}
