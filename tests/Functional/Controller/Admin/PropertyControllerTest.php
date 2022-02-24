<?php

declare(strict_types=1);

namespace Tests\Functional\Controller\Admin;

use App\Entity\Property;
use App\Entity\User;
use Tests\Functional\FixturesAwareTestCase;

final class PropertyControllerTest extends FixturesAwareTestCase
{
    /**
     * @testdox Accessing "/admin/properties/{id}/clone" returns an HTTP 200 response.
     * @noinspection SpellCheckingInspection
     */
    public function testClone(): void
    {
        $client = self::createClient();
        $client->loginUser($this->findEntityBy(User::class, ['username' => 'admin']));
        $property = $this->findEntityBy(Property::class, ['name' => 'a']);
        $client->request('GET', '/admin/properties/' . $property->getId() . '/clone');

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('h5', 'New property');
    }

    /**
     * @testdox Accessing "/admin/properties/{id}/clone" with an invalid ID returns an HTTP 404 response.
     */
    public function testCloneWithInvalidId(): void
    {
        $client = self::createClient();
        $client->loginUser($this->findEntityBy(User::class, ['username' => 'admin']));
        $client->request('GET', '/admin/properties/433e64de-3c18-4a96-a63f-9a91e2acbace/clone');

        self::assertResponseStatusCodeSame(404);
    }

    /**
     * @testdox Accessing "/admin/properties/create" returns an HTTP 200 response.
     */
    public function testCreate(): void
    {
        $client = self::createClient();
        $client->loginUser($this->findEntityBy(User::class, ['username' => 'admin']));
        $client->request('GET', '/admin/properties/create');

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('h5', 'New property');
    }

    /**
     * @testdox Submitting "/admin/properties/create" creates the property.
     * @noinspection SpellCheckingInspection
     */
    public function testCreateSubmit(): void
    {
        $client = self::createClient();
        $client->loginUser($this->findEntityBy(User::class, ['username' => 'admin']));
        $client->request('GET', '/admin/properties/create');
        $client->submitForm('Save', [
            'property[name]' => 'Abscido',
            'property[slug]' => 'abscido',
        ], serverParameters: [
            'HTTP_REFERER' => '/admin/properties',
        ]);
        $client->followRedirect();

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('div', 'Property created');
    }

    /**
     * @testdox Accessing "/admin/properties/{id}/delete" returns an HTTP 200 response.
     * @noinspection SpellCheckingInspection
     */
    public function testDelete(): void
    {
        $client = self::createClient();
        $client->loginUser($this->findEntityBy(User::class, ['username' => 'admin']));
        $property = $this->findEntityBy(Property::class, ['name' => 'ad']);
        $client->request('GET', '/admin/properties/' . $property->getId() . '/delete');

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('h5', 'Delete the property');
    }

    /**
     * @testdox Accessing "/admin/properties/{id}/delete" with an invalid ID returns an HTTP 404 response.
     */
    public function testDeleteWithInvalidId(): void
    {
        $client = self::createClient();
        $client->loginUser($this->findEntityBy(User::class, ['username' => 'admin']));
        $client->request('GET', '/admin/properties/72b2a5a7-5a9e-40dd-a27b-32d5f7c83ecf/delete');

        self::assertResponseStatusCodeSame(404);
    }

    /**
     * @testdox Submitting "/admin/properties/{id}/delete" deletes the property.
     * @noinspection SpellCheckingInspection
     */
    public function testDeleteSubmit(): void
    {
        $client = self::createClient();
        $client->loginUser($this->findEntityBy(User::class, ['username' => 'admin']));
        $property = $this->findEntityBy(Property::class, ['name' => 'adipisci']);
        $client->request('GET', '/admin/properties/' . $property->getId() . '/delete');
        $client->submitForm('Delete', serverParameters: [
            'HTTP_REFERER' => '/admin/properties',
        ]);
        $client->followRedirect();

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('div', 'Property deleted');
    }

    /**
     * @testdox Accessing "/admin/properties" returns an HTTP 200 response.
     */
    public function testList(): void
    {
        $client = self::createClient();
        $client->loginUser($this->findEntityBy(User::class, ['username' => 'admin']));
        $client->request('GET', '/admin/properties');

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('h1', 'Properties');
    }

    /**
     * @testdox Accessing "/admin/properties" with an invalid page returns an HTTP 404 response.
     */
    public function testListWithInvalidPage(): void
    {
        $client = self::createClient();
        $client->loginUser($this->findEntityBy(User::class, ['username' => 'admin']));
        $client->request('GET', '/admin/properties', ['page' => 100]);

        self::assertResponseStatusCodeSame(404);
    }

    /**
     * @testdox Accessing "/admin/properties/{id}/update" returns an HTTP 200 response.
     * @noinspection SpellCheckingInspection
     */
    public function testUpdate(): void
    {
        $client = self::createClient();
        $client->loginUser($this->findEntityBy(User::class, ['username' => 'admin']));
        $property = $this->findEntityBy(Property::class, ['name' => 'alias']);
        $client->request('GET', '/admin/properties/' . $property->getId() . '/update');

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('h5', 'alias');
    }

    /**
     * @testdox Accessing "/admin/properties/{id}/update" with an invalid ID returns an HTTP 404 response.
     */
    public function testUpdateWithInvalidId(): void
    {
        $client = self::createClient();
        $client->loginUser($this->findEntityBy(User::class, ['username' => 'admin']));
        $client->request('GET', '/admin/properties/39fe6fb2-1b1e-4b37-b780-d1d9bb0b6e86/update');

        self::assertResponseStatusCodeSame(404);
    }

    /**
     * @testdox Submitting "/admin/properties/{id}/update" updates the property.
     * @noinspection SpellCheckingInspection
     */
    public function testUpdateSubmit(): void
    {
        $client = self::createClient();
        $client->loginUser($this->findEntityBy(User::class, ['username' => 'admin']));
        $property = $this->findEntityBy(Property::class, ['name' => 'aliquam']);
        $client->request('GET', '/admin/properties/' . $property->getId() . '/update');
        $client->submitForm('Save', serverParameters: [
            'HTTP_REFERER' => '/admin/properties',
        ]);
        $client->followRedirect();

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('div', 'Property updated');
    }
}
