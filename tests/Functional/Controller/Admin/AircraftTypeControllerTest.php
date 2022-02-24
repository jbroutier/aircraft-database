<?php

declare(strict_types=1);

namespace Tests\Functional\Controller\Admin;

use App\Entity\AircraftType;
use App\Entity\User;
use Tests\Functional\FixturesAwareTestCase;

final class AircraftTypeControllerTest extends FixturesAwareTestCase
{
    /**
     * @testdox Accessing "/admin/aircraft-types/{id}/clone" returns an HTTP 200 response.
     */
    public function testClone(): void
    {
        $client = self::createClient();
        $client->loginUser($this->findEntityBy(User::class, ['username' => 'admin']));
        $aircraftType = $this->findEntityBy(AircraftType::class, ['name' => 'A248-29']);
        $client->request('GET', '/admin/aircraft-types/' . $aircraftType->getId() . '/clone');

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('h5', 'New aircraft type');
    }

    /**
     * @testdox Accessing "/admin/aircraft-types/{id}/clone" with an invalid ID returns an HTTP 404 response.
     */
    public function testCloneWithInvalidId(): void
    {
        $client = self::createClient();
        $client->loginUser($this->findEntityBy(User::class, ['username' => 'admin']));
        $client->request('GET', '/admin/aircraft-types/ce282415-7b36-4d4b-9995-909ba2839d49/clone');

        self::assertResponseStatusCodeSame(404);
    }

    /**
     * @testdox Accessing "/admin/aircraft-types/create" returns an HTTP 200 response.
     */
    public function testCreate(): void
    {
        $client = self::createClient();
        $client->loginUser($this->findEntityBy(User::class, ['username' => 'admin']));
        $client->request('GET', '/admin/aircraft-types/create');

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('h5', 'New aircraft type');
    }

    /**
     * @testdox Submitting "/admin/aircraft-types/create" creates the aircraft type.
     */
    public function testCreateSubmit(): void
    {
        $client = self::createClient();
        $client->loginUser($this->findEntityBy(User::class, ['username' => 'admin']));
        $client->request('GET', '/admin/aircraft-types/create');
        $client->submitForm('Save', [
            'aircraft_type[name]' => 'BR4-7',
            'aircraft_type[slug]' => 'BR4-7',
        ], serverParameters: [
            'HTTP_REFERER' => '/admin/aircraft-types',
        ]);
        $client->followRedirect();

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('div', 'Aircraft type created');
    }

    /**
     * @testdox Accessing "/admin/aircraft-types/{id}/delete" returns an HTTP 200 response.
     */
    public function testDelete(): void
    {
        $client = self::createClient();
        $client->loginUser($this->findEntityBy(User::class, ['username' => 'admin']));
        $aircraftType = $this->findEntityBy(AircraftType::class, ['name' => 'A668-5']);
        $client->request('GET', '/admin/aircraft-types/' . $aircraftType->getId() . '/delete');

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('h5', 'Delete the aircraft type');
    }

    /**
     * @testdox Accessing "/admin/aircraft-types/{id}/delete" with an invalid ID returns an HTTP 404 response.
     */
    public function testDeleteWithInvalidId(): void
    {
        $client = self::createClient();
        $client->loginUser($this->findEntityBy(User::class, ['username' => 'admin']));
        $client->request('GET', '/admin/aircraft-types/861767d6-7490-41ab-a97f-8ff8ed43b61b/delete');

        self::assertResponseStatusCodeSame(404);
    }

    /**
     * @testdox Submitting "/admin/aircraft-types/{id}/delete" deletes the aircraft type.
     */
    public function testDeleteSubmit(): void
    {
        $client = self::createClient();
        $client->loginUser($this->findEntityBy(User::class, ['username' => 'admin']));
        $aircraftType = $this->findEntityBy(AircraftType::class, ['name' => 'A885-6010']);
        $client->request('GET', '/admin/aircraft-types/' . $aircraftType->getId() . '/delete');
        $client->submitForm('Delete', serverParameters: [
            'HTTP_REFERER' => '/admin/aircraft-types',
        ]);
        $client->followRedirect();

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('div', 'Aircraft type deleted');
    }

    /**
     * @testdox Accessing "/admin/aircraft-types" returns an HTTP 200 response.
     */
    public function testList(): void
    {
        $client = self::createClient();
        $client->loginUser($this->findEntityBy(User::class, ['username' => 'admin']));
        $client->request('GET', '/admin/aircraft-types');

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('h1', 'Aircraft types');
    }

    /**
     * @testdox Accessing "/admin/aircraft-types" with an invalid page returns an HTTP 404 response.
     */
    public function testListWithInvalidPage(): void
    {
        $client = self::createClient();
        $client->loginUser($this->findEntityBy(User::class, ['username' => 'admin']));
        $client->request('GET', '/admin/aircraft-types', ['page' => 100]);

        self::assertResponseStatusCodeSame(404);
    }

    /**
     * @testdox Accessing "/admin/aircraft-types/{id}/update" returns an HTTP 200 response.
     */
    public function testUpdate(): void
    {
        $client = self::createClient();
        $client->loginUser($this->findEntityBy(User::class, ['username' => 'admin']));
        $aircraftType = $this->findEntityBy(AircraftType::class, ['name' => 'AF851-2106']);
        $client->request('GET', '/admin/aircraft-types/' . $aircraftType->getId() . '/update');

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('h5', 'AF851-2106');
    }

    /**
     * @testdox Accessing "/admin/aircraft-types/{id}/update" with an invalid ID returns an HTTP 404 response.
     */
    public function testUpdateWithInvalidId(): void
    {
        $client = self::createClient();
        $client->loginUser($this->findEntityBy(User::class, ['username' => 'admin']));
        $client->request('GET', '/admin/aircraft-types/a3e83fe9-cdd8-44ac-a351-45af55c610d6/update');

        self::assertResponseStatusCodeSame(404);
    }

    /**
     * @testdox Submitting "/admin/aircraft-types/{id}/update" updates the aircraft type.
     */
    public function testUpdateSubmit(): void
    {
        $client = self::createClient();
        $client->loginUser($this->findEntityBy(User::class, ['username' => 'admin']));
        $aircraftType = $this->findEntityBy(AircraftType::class, ['name' => 'AH18-1']);
        $client->request('GET', '/admin/aircraft-types/' . $aircraftType->getId() . '/update');
        $client->submitForm('Save', serverParameters: [
            'HTTP_REFERER' => '/admin/aircraft-types',
        ]);
        $client->followRedirect();

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('div', 'Aircraft type updated');
    }
}
