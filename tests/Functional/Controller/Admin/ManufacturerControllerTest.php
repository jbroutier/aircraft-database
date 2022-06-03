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
     */
    public function testClone(): void
    {
        $client = self::createClient();
        $client->loginUser($this->findEntityBy(User::class, ['username' => 'admin']));
        $manufacturer = $this->findEntityBy(Manufacturer::class, ['name' => 'Bernier Inc']);
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
     */
    public function testCreateSubmit(): void
    {
        $client = self::createClient();
        $client->loginUser($this->findEntityBy(User::class, ['username' => 'admin']));
        $client->request('GET', '/admin/manufacturers/create');
        $client->submitForm('Save', [
            'manufacturer[name]' => 'Waters Bergman Ltd',
            'manufacturer[slug]' => 'waters-bergman-ltd',
        ], serverParameters: [
            'HTTP_REFERER' => '/admin/manufacturers',
        ]);
        $client->followRedirect();

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('div', 'Manufacturer created');
    }

    /**
     * @testdox Accessing "/admin/manufacturers/{id}/delete" returns an HTTP 200 response.
     */
    public function testDelete(): void
    {
        $client = self::createClient();
        $client->loginUser($this->findEntityBy(User::class, ['username' => 'admin']));
        $manufacturer = $this->findEntityBy(Manufacturer::class, ['name' => 'Carter-Haag']);
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
     */
    public function testDeleteSubmit(): void
    {
        $client = self::createClient();
        $client->loginUser($this->findEntityBy(User::class, ['username' => 'admin']));
        $manufacturer = $this->findEntityBy(Manufacturer::class, ['name' => 'Gusikowski, Rolfson and Schoen']);
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
        $client->request('GET', '/admin/manufacturers', ['page' => 100]);

        self::assertResponseStatusCodeSame(404);
    }

    /**
     * @testdox Accessing "/admin/manufacturers/{id}/update" returns an HTTP 200 response.
     */
    public function testUpdate(): void
    {
        $client = self::createClient();
        $client->loginUser($this->findEntityBy(User::class, ['username' => 'admin']));
        $manufacturer = $this->findEntityBy(Manufacturer::class, ['name' => 'Kuphal-Kutch']);
        $client->request('GET', '/admin/manufacturers/' . $manufacturer->getId() . '/update');

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('h5', 'Kuphal-Kutch');
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
     */
    public function testUpdateSubmit(): void
    {
        $client = self::createClient();
        $client->loginUser($this->findEntityBy(User::class, ['username' => 'admin']));
        $manufacturer = $this->findEntityBy(Manufacturer::class, ['name' => 'Mitchell-Conn']);
        $client->request('GET', '/admin/manufacturers/' . $manufacturer->getId() . '/update');
        $client->submitForm('Save', serverParameters: [
            'HTTP_REFERER' => '/admin/manufacturers',
        ]);
        $client->followRedirect();

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('div', 'Manufacturer updated');
    }
}
