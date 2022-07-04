<?php

declare(strict_types=1);

namespace Tests\Functional\Controller\Admin;

use App\Entity\Tag;
use App\Entity\User;
use App\Factory\TagFactory;
use App\Factory\UserFactory;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Uid\Uuid;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

final class TagControllerTest extends WebTestCase
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
     * @testdox Accessing "/admin/tags/{id}/clone" returns an HTTP 200 response.
     */
    public function testClone(): void
    {
        /** @var Proxy<Tag> $tag */
        $tag = TagFactory::createOne();
        $tag
            ->forceSet('id', Uuid::fromRfc4122('dadf12f8-3cd8-40cc-9fd4-4b9dcbcbe30a'))
            ->save();

        $this->client->request('GET', '/admin/tags/dadf12f8-3cd8-40cc-9fd4-4b9dcbcbe30a/clone');

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('h5', 'New tag');
    }

    /**
     * @testdox Accessing "/admin/tags/{id}/clone" with an invalid ID returns an HTTP 404 response.
     */
    public function testCloneWithInvalidId(): void
    {
        $this->client->request('GET', '/admin/tags/4748fad4-f0cf-4f1d-b924-f1f66e9db84a/clone');

        self::assertResponseStatusCodeSame(404);
    }

    /**
     * @testdox Accessing "/admin/tags/create" returns an HTTP 200 response.
     */
    public function testCreate(): void
    {
        $this->client->request('GET', '/admin/tags/create');

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('h5', 'New tag');
    }

    /**
     * @testdox Submitting "/admin/tags/create" creates the tag.
     */
    public function testCreateSubmit(): void
    {
        $this->client->request('GET', '/admin/tags/create');
        $this->client->submitForm('Save', [
            'tag[color]' => '#e1ac4d',
            'tag[name]' => 'Prototype',
            'tag[slug]' => 'prototype',
        ], serverParameters: ['HTTP_REFERER' => '/admin/tags']);
        $this->client->followRedirect();

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('div', 'The tag has been created.');
    }

    /**
     * @testdox Accessing "/admin/tags/{id}/delete" returns an HTTP 200 response.
     */
    public function testDelete(): void
    {
        /** @var Proxy<Tag> $tag */
        $tag = TagFactory::createOne();
        $tag
            ->forceSet('id', Uuid::fromRfc4122('acef6c71-1193-40d8-9aa9-dc2748a0f378'))
            ->save();

        $this->client->request('GET', '/admin/tags/acef6c71-1193-40d8-9aa9-dc2748a0f378/delete');

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('h5', 'Delete the tag');
    }

    /**
     * @testdox Accessing "/admin/tags/{id}/delete" with an invalid ID returns an HTTP 404 response.
     */
    public function testDeleteWithInvalidId(): void
    {
        $this->client->request('GET', '/admin/tags/537ae19a-9365-49ec-81a2-d44ebf621a45/delete');

        self::assertResponseStatusCodeSame(404);
    }

    /**
     * @testdox Submitting "/admin/tags/{id}/delete" deletes the tag.
     */
    public function testDeleteSubmit(): void
    {
        /** @var Proxy<Tag> $tag */
        $tag = TagFactory::createOne();
        $tag
            ->forceSet('id', Uuid::fromRfc4122('9ba53355-3684-4e1e-8bb3-12ee99f90389'))
            ->save();

        $this->client->request('GET', '/admin/tags/9ba53355-3684-4e1e-8bb3-12ee99f90389/delete');
        $this->client->submitForm('Delete', serverParameters: ['HTTP_REFERER' => '/admin/tags']);
        $this->client->followRedirect();

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('div', 'The tag has been deleted.');
    }

    /**
     * @testdox Accessing "/admin/tags" returns an HTTP 200 response.
     */
    public function testList(): void
    {
        $this->client->request('GET', '/admin/tags');

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('h1', 'Tags');
    }

    /**
     * @testdox Accessing "/admin/tags" with filters returns an HTTP 200 response.
     */
    public function testListWithFilters(): void
    {
        $this->client->request('GET', '/admin/tags');
        $this->client->submitForm('Apply', [
            'filters[name]' => 'Canceled',
        ], 'GET');

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('h1', 'Tags');
    }

    /**
     * @testdox Accessing "/admin/tags" with an invalid page returns an HTTP 404 response.
     */
    public function testListWithInvalidPage(): void
    {
        $this->client->request('GET', '/admin/tags', ['page' => 10]);

        self::assertResponseStatusCodeSame(404);
    }

    /**
     * @testdox Accessing "/admin/tags/{id}/update" returns an HTTP 200 response.
     */
    public function testUpdate(): void
    {
        /** @var Proxy<Tag> $tag */
        $tag = TagFactory::createOne(['name' => 'Experimental']);
        $tag
            ->forceSet('id', Uuid::fromRfc4122('9405044a-4af1-420a-97c4-cdac1bcbce71'))
            ->save();

        $this->client->request('GET', '/admin/tags/9405044a-4af1-420a-97c4-cdac1bcbce71/update');

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('h5', 'Experimental');
    }

    /**
     * @testdox Accessing "/admin/tags/{id}/update" with an invalid ID returns an HTTP 404 response.
     */
    public function testUpdateWithInvalidId(): void
    {
        $this->client->request('GET', '/admin/tags/f25e84df-74eb-4e0f-aa65-cf58de7b852b/update');

        self::assertResponseStatusCodeSame(404);
    }

    /**
     * @testdox Submitting "/admin/tags/{id}/update" updates the tag.
     */
    public function testUpdateSubmit(): void
    {
        /** @var Proxy<Tag> $tag */
        $tag = TagFactory::createOne(['name' => 'Experimental']);
        $tag
            ->forceSet('id', Uuid::fromRfc4122('8d8efe09-b168-405b-b8e4-dd94e4fae39c'))
            ->save();

        $this->client->request('GET', '/admin/tags/8d8efe09-b168-405b-b8e4-dd94e4fae39c/update');
        $this->client->submitForm('Save', [
            'tag[color]' => '#2d7c13',
            'tag[name]' => 'Canceled',
            'tag[slug]' => 'canceled',
        ], serverParameters: ['HTTP_REFERER' => '/admin/tags']);
        $this->client->followRedirect();

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('div', 'The tag has been updated.');
    }
}
