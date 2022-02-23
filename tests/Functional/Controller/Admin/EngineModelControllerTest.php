<?php

declare(strict_types=1);

namespace Tests\Functional\Controller\Admin;

use App\Entity\EngineModel;
use App\Entity\User;
use Tests\Functional\FixturesAwareTestCase;

final class EngineModelControllerTest extends FixturesAwareTestCase
{
    /**
     * @testdox Accessing "/admin/engine-models/{id}/clone" returns an HTTP 200 response.
     * @noinspection SpellCheckingInspection
     */
    public function testClone(): void
    {
        $client = self::createClient();
        $client->loginUser($this->findEntityBy(User::class, ['username' => 'admin']));
        $engineModel = $this->findEntityBy(EngineModel::class, [
            'slug' => 'quis-omnis-aut-aut-quia-minus-rerum',
        ]);
        $client->request('GET', '/admin/engine-models/' . $engineModel->getId() . '/clone');

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('h5', 'New engine model');
    }

    /**
     * @testdox Accessing "/admin/engine-models/{id}/clone" with an invalid ID returns an HTTP 404 response.
     */
    public function testCloneWithInvalidId(): void
    {
        $client = self::createClient();
        $client->loginUser($this->findEntityBy(User::class, ['username' => 'admin']));
        $client->request('GET', '/admin/engine-models/f0f57866-a7bd-4a46-a646-d467d04c5808/clone');

        self::assertResponseStatusCodeSame(404);
    }

    /**
     * @testdox Accessing "/admin/engine-models/create" returns an HTTP 200 response.
     */
    public function testCreate(): void
    {
        $client = self::createClient();
        $client->loginUser($this->findEntityBy(User::class, ['username' => 'admin']));
        $client->request('GET', '/admin/engine-models/create');

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('h5', 'New engine model');
    }

    /**
     * @testdox Submitting "/admin/engine-models/create" creates the engine model.
     * @noinspection SpellCheckingInspection
     */
    public function testCreateSubmit(): void
    {
        $client = self::createClient();
        $client->loginUser($this->findEntityBy(User::class, ['username' => 'admin']));
        $client->request('GET', '/admin/engine-models/create');
        $client->submitForm('Save', [
            'engine_model[name]' => 'Nam libero consequuntur velit',
            'engine_model[slug]' => 'nam-libero-consequuntur-velit',
        ], serverParameters: [
            'HTTP_REFERER' => '/admin/engine-models',
        ]);
        $client->followRedirect();

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('div', 'Engine model created');
    }

    /**
     * @testdox Accessing "/admin/engine-models/{id}/delete" returns an HTTP 200 response.
     * @noinspection SpellCheckingInspection
     */
    public function testDelete(): void
    {
        $client = self::createClient();
        $client->loginUser($this->findEntityBy(User::class, ['username' => 'admin']));
        $engineModel = $this->findEntityBy(EngineModel::class, [
            'slug' => 'fugiat-voluptatem-deserunt-dicta',
        ]);
        $client->request('GET', '/admin/engine-models/' . $engineModel->getId() . '/delete');

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('h5', 'Delete the engine model');
    }

    /**
     * @testdox Accessing "/admin/engine-models/{id}/delete" with an invalid ID returns an HTTP 404 response.
     */
    public function testDeleteWithInvalidId(): void
    {
        $client = self::createClient();
        $client->loginUser($this->findEntityBy(User::class, ['username' => 'admin']));
        $client->request('GET', '/admin/engine-models/b3e0f683-d0e8-4bcc-9cae-3bae1c979c5f/delete');

        self::assertResponseStatusCodeSame(404);
    }

    /**
     * @testdox Submitting "/admin/engine-models/{id}/delete" deletes the engine model.
     * @noinspection SpellCheckingInspection
     */
    public function testDeleteSubmit(): void
    {
        $client = self::createClient();
        $client->loginUser($this->findEntityBy(User::class, ['username' => 'admin']));
        $engineModel = $this->findEntityBy(EngineModel::class, [
            'slug' => 'fugiat-voluptatem-deserunt-dicta',
        ]);
        $client->request('GET', '/admin/engine-models/' . $engineModel->getId() . '/delete');
        $client->submitForm('Delete', serverParameters: [
            'HTTP_REFERER' => '/admin/engine-models',
        ]);
        $client->followRedirect();

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('div', 'Engine model deleted');
    }

    /**
     * @testdox Accessing "/admin/engine-models" returns an HTTP 200 response.
     */
    public function testList(): void
    {
        $client = self::createClient();
        $client->loginUser($this->findEntityBy(User::class, ['username' => 'admin']));
        $client->request('GET', '/admin/engine-models');

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('h1', 'Engine models');
    }

    /**
     * @testdox Accessing "/admin/engine-models" with an invalid page returns an HTTP 404 response.
     */
    public function testListWithInvalidPage(): void
    {
        $client = self::createClient();
        $client->loginUser($this->findEntityBy(User::class, ['username' => 'admin']));
        $client->request('GET', '/admin/engine-models', ['page' => 101]);

        self::assertResponseStatusCodeSame(404);
    }

    /**
     * @testdox Accessing "/admin/engine-models/{id}/update" returns an HTTP 200 response.
     * @noinspection SpellCheckingInspection
     */
    public function testUpdate(): void
    {
        $client = self::createClient();
        $client->loginUser($this->findEntityBy(User::class, ['username' => 'admin']));
        $engineModel = $this->findEntityBy(EngineModel::class, [
            'slug' => 'possimus-quo-laboriosam-optio-doloremque-suscipit-laborum-officiis',
        ]);
        $client->request('GET', '/admin/engine-models/' . $engineModel->getId() . '/update');

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('h5', 'A7-1');
    }

    /**
     * @testdox Accessing "/admin/engine-models/{id}/update" with an invalid ID returns an HTTP 404 response.
     */
    public function testUpdateWithInvalidId(): void
    {
        $client = self::createClient();
        $client->loginUser($this->findEntityBy(User::class, ['username' => 'admin']));
        $client->request('GET', '/admin/engine-models/1bd6531f-533e-44b2-b5da-12dcd4a147dc/update');

        self::assertResponseStatusCodeSame(404);
    }

    /**
     * @testdox Submitting "/admin/engine-models/{id}/update" updates the engine model.
     * @noinspection SpellCheckingInspection
     */
    public function testUpdateSubmit(): void
    {
        $client = self::createClient();
        $client->loginUser($this->findEntityBy(User::class, ['username' => 'admin']));
        $engineModel = $this->findEntityBy(EngineModel::class, [
            'slug' => 'possimus-quo-laboriosam-optio-doloremque-suscipit-laborum-officiis',
        ]);
        $client->request('GET', '/admin/engine-models/' . $engineModel->getId() . '/update');
        $client->submitForm('Save', serverParameters: [
            'HTTP_REFERER' => '/admin/engine-models',
        ]);
        $client->followRedirect();

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('div', 'Engine model updated');
    }
}
