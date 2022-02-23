<?php

declare(strict_types=1);

namespace Tests\Functional\Controller\Admin;

use App\Entity\PropertyGroup;
use App\Entity\User;
use Tests\Functional\FixturesAwareTestCase;

final class PropertyGroupControllerTest extends FixturesAwareTestCase
{
    /**
     * @testdox Accessing "/admin/property-groups/{id}/clone" returns an HTTP 200 response.
     * @noinspection SpellCheckingInspection
     */
    public function testClone(): void
    {
        $client = self::createClient();
        $client->loginUser($this->findEntityBy(User::class, ['username' => 'admin']));
        $propertyGroup = $this->findEntityBy(PropertyGroup::class, [
            'name' => 'Aperiam.',
        ]);
        $client->request('GET', '/admin/property-groups/' . $propertyGroup->getId() . '/clone');

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('h5', 'New property group');
    }

    /**
     * @testdox Accessing "/admin/property-groups/{id}/clone" with an invalid ID returns an HTTP 404 response.
     */
    public function testCloneWithInvalidId(): void
    {
        $client = self::createClient();
        $client->loginUser($this->findEntityBy(User::class, ['username' => 'admin']));
        $client->request('GET', '/admin/property-groups/8e54d785-ae79-4afc-95e4-f5bd3c15ceb0/clone');

        self::assertResponseStatusCodeSame(404);
    }

    /**
     * @testdox Accessing "/admin/property-groups/create" returns an HTTP 200 response.
     */
    public function testCreate(): void
    {
        $client = self::createClient();
        $client->loginUser($this->findEntityBy(User::class, ['username' => 'admin']));
        $client->request('GET', '/admin/property-groups/create');

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('h5', 'New property group');
    }

    /**
     * @testdox Submitting "/admin/property-groups/create" creates the property group.
     * @noinspection SpellCheckingInspection
     */
    public function testCreateSubmit(): void
    {
        $client = self::createClient();
        $client->loginUser($this->findEntityBy(User::class, ['username' => 'admin']));
        $client->request('GET', '/admin/property-groups/create');
        $client->submitForm('Save', [
            'property_group[name]' => 'Harum similique autem omnis',
        ], serverParameters: [
            'HTTP_REFERER' => '/admin/property-groups',
        ]);
        $client->followRedirect();

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('div', 'Property group created');
    }

    /**
     * @testdox Accessing "/admin/property-groups/{id}/delete" returns an HTTP 200 response.
     * @noinspection SpellCheckingInspection
     */
    public function testDelete(): void
    {
        $client = self::createClient();
        $client->loginUser($this->findEntityBy(User::class, ['username' => 'admin']));
        $propertyGroup = $this->findEntityBy(PropertyGroup::class, [
            'name' => 'Est illo.',
        ]);
        $client->request('GET', '/admin/property-groups/' . $propertyGroup->getId() . '/delete');

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('h5', 'Delete the property group');
    }

    /**
     * @testdox Accessing "/admin/property-groups/{id}/delete" with an invalid ID returns an HTTP 404 response.
     */
    public function testDeleteWithInvalidId(): void
    {
        $client = self::createClient();
        $client->loginUser($this->findEntityBy(User::class, ['username' => 'admin']));
        $client->request('GET', '/admin/property-groups/fd722272-e3d0-427f-8466-9da6aa926ab6/delete');

        self::assertResponseStatusCodeSame(404);
    }

    /**
     * @testdox Submitting "/admin/property-groups/{id}/delete" deletes the property group.
     * @noinspection SpellCheckingInspection
     */
    public function testDeleteSubmit(): void
    {
        $client = self::createClient();
        $client->loginUser($this->findEntityBy(User::class, ['username' => 'admin']));
        $propertyGroup = $this->findEntityBy(PropertyGroup::class, [
            'name' => 'Est illo.',
        ]);
        $client->request('GET', '/admin/property-groups/' . $propertyGroup->getId() . '/delete');
        $client->submitForm('Delete', serverParameters: [
            'HTTP_REFERER' => '/admin/property-groups',
        ]);
        $client->followRedirect();

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('div', 'Property group deleted');
    }

    /**
     * @testdox Accessing "/admin/property-groups" returns an HTTP 200 response.
     */
    public function testList(): void
    {
        $client = self::createClient();
        $client->loginUser($this->findEntityBy(User::class, ['username' => 'admin']));
        $client->request('GET', '/admin/property-groups');

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('h1', 'Property groups');
    }

    /**
     * @testdox Accessing "/admin/property-groups" with an invalid page returns an HTTP 404 response.
     */
    public function testListWithInvalidPage(): void
    {
        $client = self::createClient();
        $client->loginUser($this->findEntityBy(User::class, ['username' => 'admin']));
        $client->request('GET', '/admin/property-groups', ['page' => 101]);

        self::assertResponseStatusCodeSame(404);
    }

    /**
     * @testdox Accessing "/admin/property-groups/{id}/update" returns an HTTP 200 response.
     * @noinspection SpellCheckingInspection
     */
    public function testUpdate(): void
    {
        $client = self::createClient();
        $client->loginUser($this->findEntityBy(User::class, ['username' => 'admin']));
        $propertyGroup = $this->findEntityBy(PropertyGroup::class, [
            'name' => 'Molestiae.',
        ]);
        $client->request('GET', '/admin/property-groups/' . $propertyGroup->getId() . '/update');

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('h5', 'Molestiae');
    }

    /**
     * @testdox Accessing "/admin/property-groups/{id}/update" with an invalid ID returns an HTTP 404 response.
     */
    public function testUpdateWithInvalidId(): void
    {
        $client = self::createClient();
        $client->loginUser($this->findEntityBy(User::class, ['username' => 'admin']));
        $client->request('GET', '/admin/property-groups/211531c3-9c1f-442c-824d-9b6a92e191d6/update');

        self::assertResponseStatusCodeSame(404);
    }

    /**
     * @testdox Submitting "/admin/property-groups/{id}/update" updates the property group.
     * @noinspection SpellCheckingInspection
     */
    public function testUpdateSubmit(): void
    {
        $client = self::createClient();
        $client->loginUser($this->findEntityBy(User::class, ['username' => 'admin']));
        $propertyGroup = $this->findEntityBy(PropertyGroup::class, [
            'name' => 'Molestiae.',
        ]);
        $client->request('GET', '/admin/property-groups/' . $propertyGroup->getId() . '/update');
        $client->submitForm('Save', serverParameters: [
            'HTTP_REFERER' => '/admin/property-groups',
        ]);
        $client->followRedirect();

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('div', 'Property group updated');
    }
}
