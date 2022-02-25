<?php

declare(strict_types=1);

namespace Tests\Functional\Controller\Admin;

use App\Entity\AircraftModel;
use App\Entity\User;
use Tests\Functional\FixturesAwareTestCase;

final class AircraftModelControllerTest extends FixturesAwareTestCase
{
    /**
     * @testdox Accessing "/admin/aircraft-models/{id}/clone" returns an HTTP 200 response.
     */
    public function testClone(): void
    {
        $client = self::createClient();
        $client->loginUser($this->findEntityBy(User::class, ['username' => 'admin']));
        $aircraftModel = $this->findEntityBy(AircraftModel::class, ['name' => 'A668-5']);
        $client->request('GET', '/admin/aircraft-models/' . $aircraftModel->getId() . '/clone');

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('h5', 'New aircraft model');
    }

    /**
     * @testdox Accessing "/admin/aircraft-models/{id}/clone" with an invalid ID returns an HTTP 404 response.
     */
    public function testCloneWithInvalidId(): void
    {
        $client = self::createClient();
        $client->loginUser($this->findEntityBy(User::class, ['username' => 'admin']));
        $client->request('GET', '/admin/aircraft-models/9a388f8c-6699-4f38-ab97-3b1adeaddcef/clone');

        self::assertResponseStatusCodeSame(404);
    }

    /**
     * @testdox Accessing "/admin/aircraft-models/create" returns an HTTP 200 response.
     */
    public function testCreate(): void
    {
        $client = self::createClient();
        $client->loginUser($this->findEntityBy(User::class, ['username' => 'admin']));
        $client->request('GET', '/admin/aircraft-models/create');

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('h5', 'New aircraft model');
    }

    /**
     * @testdox Submitting "/admin/aircraft-models/create" creates the aircraft model.
     */
    public function testCreateSubmit(): void
    {
        $client = self::createClient();
        $client->loginUser($this->findEntityBy(User::class, ['username' => 'admin']));
        $client->request('GET', '/admin/aircraft-models/create');
        $client->submitForm('Save', [
            'aircraft_model[name]' => 'B32-784',
            'aircraft_model[slug]' => 'B32-784',
        ], serverParameters: [
            'HTTP_REFERER' => '/admin/aircraft-models',
        ]);
        $client->followRedirect();

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('div', 'Aircraft model created');
    }

    /**
     * @testdox Accessing "/admin/aircraft-models/{id}/delete" returns an HTTP 200 response.
     */
    public function testDelete(): void
    {
        $client = self::createClient();
        $client->loginUser($this->findEntityBy(User::class, ['username' => 'admin']));
        $aircraftModel = $this->findEntityBy(AircraftModel::class, ['name' => 'AF851-2106']);
        $client->request('GET', '/admin/aircraft-models/' . $aircraftModel->getId() . '/delete');

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('h5', 'Delete the aircraft model');
    }

    /**
     * @testdox Accessing "/admin/aircraft-models/{id}/delete" with an invalid ID returns an HTTP 404 response.
     */
    public function testDeleteWithInvalidId(): void
    {
        $client = self::createClient();
        $client->loginUser($this->findEntityBy(User::class, ['username' => 'admin']));
        $client->request('GET', '/admin/aircraft-models/dd3784cc-dd65-48b5-bfd9-6c2063cc880f/delete');

        self::assertResponseStatusCodeSame(404);
    }

    /**
     * @testdox Submitting "/admin/aircraft-models/{id}/delete" deletes the aircraft model.
     */
    public function testDeleteSubmit(): void
    {
        $client = self::createClient();
        $client->loginUser($this->findEntityBy(User::class, ['username' => 'admin']));
        $aircraftModel = $this->findEntityBy(AircraftModel::class, ['name' => 'B9-7']);
        $client->request('GET', '/admin/aircraft-models/' . $aircraftModel->getId() . '/delete');
        $client->submitForm('Delete', serverParameters: [
            'HTTP_REFERER' => '/admin/aircraft-models',
        ]);
        $client->followRedirect();

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('div', 'Aircraft model deleted');
    }

    /**
     * @testdox Accessing "/admin/aircraft-models" returns an HTTP 200 response.
     */
    public function testList(): void
    {
        $client = self::createClient();
        $client->loginUser($this->findEntityBy(User::class, ['username' => 'admin']));
        $client->request('GET', '/admin/aircraft-models');

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('h1', 'Aircraft models');
    }

    /**
     * @testdox Accessing "/admin/aircraft-models" with an invalid page returns an HTTP 404 response.
     */
    public function testListWithInvalidPage(): void
    {
        $client = self::createClient();
        $client->loginUser($this->findEntityBy(User::class, ['username' => 'admin']));
        $client->request('GET', '/admin/aircraft-models', ['page' => 100]);

        self::assertResponseStatusCodeSame(404);
    }

    /**
     * @testdox Accessing "/admin/aircraft-models/{id}/update" returns an HTTP 200 response.
     */
    public function testUpdate(): void
    {
        $client = self::createClient();
        $client->loginUser($this->findEntityBy(User::class, ['username' => 'admin']));
        $aircraftModel = $this->findEntityBy(AircraftModel::class, ['name' => 'BF436-3452']);
        $client->request('GET', '/admin/aircraft-models/' . $aircraftModel->getId() . '/update');

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('h5', 'BF436-3452');
    }

    /**
     * @testdox Accessing "/admin/aircraft-models/{id}/update" with an invalid ID returns an HTTP 404 response.
     */
    public function testUpdateWithInvalidId(): void
    {
        $client = self::createClient();
        $client->loginUser($this->findEntityBy(User::class, ['username' => 'admin']));
        $client->request('GET', '/admin/aircraft-models/f799d9c3-0677-4cc5-aecf-cdb920efd6aa/update');

        self::assertResponseStatusCodeSame(404);
    }

    /**
     * @testdox Submitting "/admin/aircraft-models/{id}/update" updates the aircraft model.
     */
    public function testUpdateSubmit(): void
    {
        $client = self::createClient();
        $client->loginUser($this->findEntityBy(User::class, ['username' => 'admin']));
        $aircraftModel = $this->findEntityBy(AircraftModel::class, ['name' => 'BN551-171']);
        $client->request('GET', '/admin/aircraft-models/' . $aircraftModel->getId() . '/update');
        $client->submitForm('Save', serverParameters: [
            'HTTP_REFERER' => '/admin/aircraft-models',
        ]);
        $client->followRedirect();

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('div', 'Aircraft model updated');
    }
}
