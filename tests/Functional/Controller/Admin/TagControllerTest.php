<?php

declare(strict_types=1);

namespace Tests\Functional\Controller\Admin;

use App\Entity\Tag;
use App\Entity\User;
use Tests\Functional\FixturesAwareTestCase;

final class TagControllerTest extends FixturesAwareTestCase
{
    /**
     * @testdox Accessing "/admin/tags/{id}/clone" returns an HTTP 200 response.
     * @noinspection SpellCheckingInspection
     */
    public function testClone(): void
    {
        $client = self::createClient();
        $client->loginUser($this->findEntityBy(User::class, ['username' => 'admin']));
        $tag = $this->findEntityBy(Tag::class, [
            'slug' => 'quis-odit-maiores-in',
        ]);
        $client->request('GET', '/admin/tags/' . $tag->getId() . '/clone');

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('h5', 'New tag');
    }

    /**
     * @testdox Accessing "/admin/tags/{id}/clone" with an invalid ID returns an HTTP 404 response.
     */
    public function testCloneWithInvalidId(): void
    {
        $client = self::createClient();
        $client->loginUser($this->findEntityBy(User::class, ['username' => 'admin']));
        $client->request('GET', '/admin/tags/4e544503-eb37-4c9b-8ccc-4e56e1560cb2/clone');

        self::assertResponseStatusCodeSame(404);
    }

    /**
     * @testdox Accessing "/admin/tags/create" returns an HTTP 200 response.
     */
    public function testCreate(): void
    {
        $client = self::createClient();
        $client->loginUser($this->findEntityBy(User::class, ['username' => 'admin']));
        $client->request('GET', '/admin/tags/create');

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('h5', 'New tag');
    }

    /**
     * @testdox Submitting "/admin/tags/create" creates the tag.
     * @noinspection SpellCheckingInspection
     */
    public function testCreateSubmit(): void
    {
        $client = self::createClient();
        $client->loginUser($this->findEntityBy(User::class, ['username' => 'admin']));
        $client->request('GET', '/admin/tags/create');
        $client->submitForm('Save', [
            'tag[color]' => '#c0ffee',
            'tag[name]' => 'Aliquam non expedita',
            'tag[slug]' => 'aliquam-non-expedita',
        ], serverParameters: [
            'HTTP_REFERER' => '/admin/tags',
        ]);
        $client->followRedirect();

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('div', 'Tag created');
    }

    /**
     * @testdox Accessing "/admin/tags/{id}/delete" returns an HTTP 200 response.
     * @noinspection SpellCheckingInspection
     */
    public function testDelete(): void
    {
        $client = self::createClient();
        $client->loginUser($this->findEntityBy(User::class, ['username' => 'admin']));
        $tag = $this->findEntityBy(Tag::class, [
            'slug' => 'nihil-fuga-ea-laborum-iste-ullam-odit-inventore',
        ]);
        $client->request('GET', '/admin/tags/' . $tag->getId() . '/delete');

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('h5', 'Delete the tag');
    }

    /**
     * @testdox Accessing "/admin/tags/{id}/delete" with an invalid ID returns an HTTP 404 response.
     */
    public function testDeleteWithInvalidId(): void
    {
        $client = self::createClient();
        $client->loginUser($this->findEntityBy(User::class, ['username' => 'admin']));
        $client->request('GET', '/admin/tags/0cb3745d-2bf4-4830-9616-717fbad31cf4/delete');

        self::assertResponseStatusCodeSame(404);
    }

    /**
     * @testdox Submitting "/admin/tags/{id}/delete" deletes the tag.
     * @noinspection SpellCheckingInspection
     */
    public function testDeleteSubmit(): void
    {
        $client = self::createClient();
        $client->loginUser($this->findEntityBy(User::class, ['username' => 'admin']));
        $tag = $this->findEntityBy(Tag::class, [
            'slug' => 'nihil-fuga-ea-laborum-iste-ullam-odit-inventore',
        ]);
        $client->request('GET', '/admin/tags/' . $tag->getId() . '/delete');
        $client->submitForm('Delete', serverParameters: [
            'HTTP_REFERER' => '/admin/tags',
        ]);
        $client->followRedirect();

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('div', 'Tag deleted');
    }

    /**
     * @testdox Accessing "/admin/tags" returns an HTTP 200 response.
     */
    public function testList(): void
    {
        $client = self::createClient();
        $client->loginUser($this->findEntityBy(User::class, ['username' => 'admin']));
        $client->request('GET', '/admin/tags');

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('h1', 'Tags');
    }

    /**
     * @testdox Accessing "/admin/tags" with an invalid page returns an HTTP 404 response.
     */
    public function testListWithInvalidPage(): void
    {
        $client = self::createClient();
        $client->loginUser($this->findEntityBy(User::class, ['username' => 'admin']));
        $client->request('GET', '/admin/tags', ['page' => 101]);

        self::assertResponseStatusCodeSame(404);
    }

    /**
     * @testdox Accessing "/admin/tags/{id}/update" returns an HTTP 200 response.
     * @noinspection SpellCheckingInspection
     */
    public function testUpdate(): void
    {
        $client = self::createClient();
        $client->loginUser($this->findEntityBy(User::class, ['username' => 'admin']));
        $tag = $this->findEntityBy(Tag::class, [
            'slug' => 'est-blanditiis-reiciendis-est',
        ]);
        $client->request('GET', '/admin/tags/' . $tag->getId() . '/update');

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('h5', 'Nobis');
    }

    /**
     * @testdox Accessing "/admin/tags/{id}/update" with an invalid ID returns an HTTP 404 response.
     */
    public function testUpdateWithInvalidId(): void
    {
        $client = self::createClient();
        $client->loginUser($this->findEntityBy(User::class, ['username' => 'admin']));
        $client->request('GET', '/admin/tags/395b9a97-8c6a-4256-98dc-ffbdeab3658e/update');

        self::assertResponseStatusCodeSame(404);
    }

    /**
     * @testdox Submitting "/admin/tags/{id}/update" updates the tag.
     * @noinspection SpellCheckingInspection
     */
    public function testUpdateSubmit(): void
    {
        $client = self::createClient();
        $client->loginUser($this->findEntityBy(User::class, ['username' => 'admin']));
        $tag = $this->findEntityBy(Tag::class, [
            'slug' => 'est-blanditiis-reiciendis-est',
        ]);
        $client->request('GET', '/admin/tags/' . $tag->getId() . '/update');
        $client->submitForm('Save', serverParameters: [
            'HTTP_REFERER' => '/admin/tags',
        ]);
        $client->followRedirect();

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('div', 'Tag updated');
    }
}
