<?php

declare(strict_types=1);

namespace Tests\Functional\Controller\Admin;

use App\Entity\Manufacturer;
use App\Entity\User;
use Tests\Functional\FixturesAwareTestCase;

final class ManufacturerControllerTest extends FixturesAwareTestCase
{
    /**
     * @testdox Accessing "/admin/manufacturers/{id}/clone" returns an HTTP 200 response.
     * @noinspection SpellCheckingInspection
     */
    public function testClone(): void
    {
        $client = self::createClient();
        $client->loginUser($this->findEntityBy(User::class, ['username' => 'admin']));
        $manufacturer = $this->findEntityBy(Manufacturer::class, [
            'slug' => 'consequatur-minima-molestiae-quam-odit-atque',
        ]);
        $client->request('GET', '/admin/manufacturers/' . $manufacturer->getId() . '/clone');

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('h5', 'New manufacturer');
    }

    /**
     * @testdox Accessing "/admin/manufacturers/{id}/clone" with an invalid ID returns an HTTP 404 response.
     */
    public function testCloneWithInvalidId(): void
    {
        $client = self::createClient();
        $client->loginUser($this->findEntityBy(User::class, ['username' => 'admin']));
        $client->request('GET', '/admin/manufacturers/2cb320e8-2946-4533-92c3-ce4c5d25b4ac/clone');

        self::assertResponseStatusCodeSame(404);
    }

    /**
     * @testdox Accessing "/admin/manufacturers/create" returns an HTTP 200 response.
     */
    public function testCreate(): void
    {
        $client = self::createClient();
        $client->loginUser($this->findEntityBy(User::class, ['username' => 'admin']));
        $client->request('GET', '/admin/manufacturers/create');

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('h5', 'New manufacturer');
    }

    /**
     * @testdox Submitting "/admin/manufacturers/create" creates the manufacturer.
     * @noinspection SpellCheckingInspection
     */
    public function testCreateSubmit(): void
    {
        $client = self::createClient();
        $client->loginUser($this->findEntityBy(User::class, ['username' => 'admin']));
        $client->request('GET', '/admin/manufacturers/create');
        $client->submitForm('Save', [
            'manufacturer[name]' => 'Voluptatum perferendis nemo',
            'manufacturer[slug]' => 'voluptatum-perferendis-nemo',
        ], serverParameters: [
            'HTTP_REFERER' => '/admin/manufacturers',
        ]);
        $client->followRedirect();

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('div', 'Manufacturer created');
    }

    /**
     * @testdox Accessing "/admin/manufacturers/{id}/delete" returns an HTTP 200 response.
     * @noinspection SpellCheckingInspection
     */
    public function testDelete(): void
    {
        $client = self::createClient();
        $client->loginUser($this->findEntityBy(User::class, ['username' => 'admin']));
        $manufacturer = $this->findEntityBy(Manufacturer::class, [
            'slug' => 'quo-sunt-est-dignissimos-nobis-illum-eum-aspernatur',
        ]);
        $client->request('GET', '/admin/manufacturers/' . $manufacturer->getId() . '/delete');

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('h5', 'Delete the manufacturer');
    }

    /**
     * @testdox Accessing "/admin/manufacturers/{id}/delete" with an invalid ID returns an HTTP 404 response.
     */
    public function testDeleteWithInvalidId(): void
    {
        $client = self::createClient();
        $client->loginUser($this->findEntityBy(User::class, ['username' => 'admin']));
        $client->request('GET', '/admin/manufacturers/4f790541-c064-4e4a-9829-112db1544537/delete');

        self::assertResponseStatusCodeSame(404);
    }

    /**
     * @testdox Submitting "/admin/manufacturers/{id}/delete" deletes the manufacturer.
     * @noinspection SpellCheckingInspection
     */
    public function testDeleteSubmit(): void
    {
        $client = self::createClient();
        $client->loginUser($this->findEntityBy(User::class, ['username' => 'admin']));
        $manufacturer = $this->findEntityBy(Manufacturer::class, [
            'slug' => 'quo-sunt-est-dignissimos-nobis-illum-eum-aspernatur',
        ]);
        $client->request('GET', '/admin/manufacturers/' . $manufacturer->getId() . '/delete');
        $client->submitForm('Delete', serverParameters: [
            'HTTP_REFERER' => '/admin/manufacturers',
        ]);
        $client->followRedirect();

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('div', 'Manufacturer deleted');
    }

    /**
     * @testdox Accessing "/admin/manufacturers" returns an HTTP 200 response.
     */
    public function testList(): void
    {
        $client = self::createClient();
        $client->loginUser($this->findEntityBy(User::class, ['username' => 'admin']));
        $client->request('GET', '/admin/manufacturers');

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('h1', 'Manufacturers');
    }

    /**
     * @testdox Accessing "/admin/manufacturers" with an invalid page returns an HTTP 404 response.
     */
    public function testListWithInvalidPage(): void
    {
        $client = self::createClient();
        $client->loginUser($this->findEntityBy(User::class, ['username' => 'admin']));
        $client->request('GET', '/admin/manufacturers', ['page' => 101]);

        self::assertResponseStatusCodeSame(404);
    }

    /**
     * @testdox Accessing "/admin/manufacturers/{id}/update" returns an HTTP 200 response.
     * @noinspection SpellCheckingInspection
     */
    public function testUpdate(): void
    {
        $client = self::createClient();
        $client->loginUser($this->findEntityBy(User::class, ['username' => 'admin']));
        $manufacturer = $this->findEntityBy(Manufacturer::class, [
            'slug' => 'et-error-omnis-fuga-accusamus-architecto-ducimus',
        ]);
        $client->request('GET', '/admin/manufacturers/' . $manufacturer->getId() . '/update');

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('h5', 'Baumbach, Goldner and Witting');
    }

    /**
     * @testdox Accessing "/admin/manufacturers/{id}/update" with an invalid ID returns an HTTP 404 response.
     */
    public function testUpdateWithInvalidId(): void
    {
        $client = self::createClient();
        $client->loginUser($this->findEntityBy(User::class, ['username' => 'admin']));
        $client->request('GET', '/admin/manufacturers/b2ef56af-4343-412c-8e39-0fe9baf0e977/update');

        self::assertResponseStatusCodeSame(404);
    }

    /**
     * @testdox Submitting "/admin/manufacturers/{id}/update" updates the manufacturer.
     * @noinspection SpellCheckingInspection
     */
    public function testUpdateSubmit(): void
    {
        $client = self::createClient();
        $client->loginUser($this->findEntityBy(User::class, ['username' => 'admin']));
        $manufacturer = $this->findEntityBy(Manufacturer::class, [
            'slug' => 'et-error-omnis-fuga-accusamus-architecto-ducimus',
        ]);
        $client->request('GET', '/admin/manufacturers/' . $manufacturer->getId() . '/update');
        $client->submitForm('Save', serverParameters: [
            'HTTP_REFERER' => '/admin/manufacturers',
        ]);
        $client->followRedirect();

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('div', 'Manufacturer updated');
    }
}
