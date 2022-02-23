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
     * @noinspection SpellCheckingInspection
     */
    public function testClone(): void
    {
        $client = self::createClient();
        $client->loginUser($this->findEntityBy(User::class, ['username' => 'admin']));
        $aircraftModel = $this->findEntityBy(AircraftModel::class, [
            'slug' => 'id-rerum-nihil-debitis',
        ]);
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
     * @noinspection SpellCheckingInspection
     */
    public function testCreateSubmit(): void
    {
        $client = self::createClient();
        $client->loginUser($this->findEntityBy(User::class, ['username' => 'admin']));
        $client->request('GET', '/admin/aircraft-models/create');
        $client->submitForm('Save', [
            'aircraft_model[name]' => 'Ut accusantium qui ipsum officiis',
            'aircraft_model[slug]' => 'ut-accusantium-qui-ipsum-officiis',
        ], serverParameters: [
            'HTTP_REFERER' => '/admin/aircraft-models',
        ]);
        $client->followRedirect();

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('div', 'Aircraft model created');
    }

    /**
     * @testdox Accessing "/admin/aircraft-models/{id}/delete" returns an HTTP 200 response.
     * @noinspection SpellCheckingInspection
     */
    public function testDelete(): void
    {
        $client = self::createClient();
        $client->loginUser($this->findEntityBy(User::class, ['username' => 'admin']));
        $aircraftModel = $this->findEntityBy(AircraftModel::class, [
            'slug' => 'beatae-dolorem-deleniti-porro',
        ]);
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
     * @noinspection SpellCheckingInspection
     */
    public function testDeleteSubmit(): void
    {
        $client = self::createClient();
        $client->loginUser($this->findEntityBy(User::class, ['username' => 'admin']));
        $aircraftModel = $this->findEntityBy(AircraftModel::class, [
            'slug' => 'beatae-dolorem-deleniti-porro',
        ]);
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
        $client->request('GET', '/admin/aircraft-models', ['page' => 101]);

        self::assertResponseStatusCodeSame(404);
    }

    /**
     * @testdox Accessing "/admin/aircraft-models/{id}/update" returns an HTTP 200 response.
     * @noinspection SpellCheckingInspection
     */
    public function testUpdate(): void
    {
        $client = self::createClient();
        $client->loginUser($this->findEntityBy(User::class, ['username' => 'admin']));
        $aircraftModel = $this->findEntityBy(AircraftModel::class, [
            'slug' => 'est-ea-ut-aut-et-et-odit',
        ]);
        $client->request('GET', '/admin/aircraft-models/' . $aircraftModel->getId() . '/update');

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('h5', 'A0-3552');
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
     * @noinspection SpellCheckingInspection
     */
    public function testUpdateSubmit(): void
    {
        $client = self::createClient();
        $client->loginUser($this->findEntityBy(User::class, ['username' => 'admin']));
        $aircraftModel = $this->findEntityBy(AircraftModel::class, [
            'slug' => 'est-ea-ut-aut-et-et-odit',
        ]);
        $client->request('GET', '/admin/aircraft-models/' . $aircraftModel->getId() . '/update');
        $client->submitForm('Save', serverParameters: [
            'HTTP_REFERER' => '/admin/aircraft-models',
        ]);
        $client->followRedirect();

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('div', 'Aircraft model updated');
    }
}
