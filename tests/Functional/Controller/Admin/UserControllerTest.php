<?php

declare(strict_types=1);

namespace Tests\Functional\Controller\Admin;

use App\Entity\User;
use App\Factory\UserFactory;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Uid\Uuid;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

final class UserControllerTest extends WebTestCase
{
    use Factories;
    use ResetDatabase;

    private KernelBrowser $client;

    public function setUp(): void
    {
        $this->client = self::createClient();

        /** @var Proxy<User> $user */
        $user = UserFactory::createOne(['roles' => ['ROLE_ADMIN']]);
        $user
            ->forceSet('id', Uuid::fromRfc4122('d025c767-0401-40a1-8a0f-00ae7a08d3e4'))
            ->save();

        $this->client->loginUser($user->object());
    }

    /**
     * @testdox Accessing "/admin/users/{id}/delete" returns an HTTP 200 response.
     */
    public function testDelete(): void
    {
        /** @var Proxy<User> $user */
        $user = UserFactory::createOne();
        $user
            ->forceSet('id', Uuid::fromRfc4122('de91a673-edae-43f8-83e9-e27ef5859ab3'))
            ->save();

        $this->client->request('GET', '/admin/users/de91a673-edae-43f8-83e9-e27ef5859ab3/delete');

        self::assertResponseStatusCodeSame(200);
    }

    /**
     * @testdox Accessing "/admin/users/{id}/delete" with an invalid ID returns an HTTP 404 response.
     */
    public function testDeleteWithInvalidId(): void
    {
        $this->client->request('GET', '/admin/users/5dc2039f-6996-41d5-a0b7-078382ce1d86/delete');

        self::assertResponseStatusCodeSame(404);
    }

    /**
     * @testdox Accessing "/admin/users/{id}/delete" with an unauthorized user returns an HTTP 403 response.
     */
    public function testDeleteWithUnauthorizedUser(): void
    {
        $this->client->request('GET', '/admin/users/d025c767-0401-40a1-8a0f-00ae7a08d3e4/delete');

        self::assertResponseStatusCodeSame(403);
    }

    /**
     * @testdox Submitting "/admin/users/{id}/delete" deletes the user.
     */
    public function testDeleteSubmit(): void
    {
        /** @var Proxy<User> $user */
        $user = UserFactory::createOne();
        $user
            ->forceSet('id', Uuid::fromRfc4122('d8e66398-5552-42bc-b9f0-7990f0f137b7'))
            ->save();

        $this->client->request('GET', '/admin/users/d8e66398-5552-42bc-b9f0-7990f0f137b7/delete');
        $this->client->submitForm('Delete', serverParameters: ['HTTP_REFERER' => '/admin/users']);
        $this->client->followRedirect();

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('div', 'The user has been deleted.');
    }

    /**
     * @testdox Accessing "/admin/users" returns an HTTP 200 response.
     */
    public function testList(): void
    {
        $this->client->request('GET', '/admin/users');

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('h1', 'Users');
    }

    /**
     * @testdox Accessing "/admin/users" with filters returns an HTTP 200 response.
     */
    public function testListWithFilters(): void
    {
        $this->client->request('GET', '/admin/users');
        $this->client->submitForm('Apply', [
            'filters[email]' => 'jeremie.broutier@posteo.net',
            'filters[firstName]' => 'Jérémie',
            'filters[lastName]' => 'Broutier',
        ], 'GET');

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('h1', 'Users');
    }

    /**
     * @testdox Accessing "/admin/users" with an invalid page returns an HTTP 404 response.
     */
    public function testListWithInvalidPage(): void
    {
        $this->client->request('GET', '/admin/users', ['page' => 10]);

        self::assertResponseStatusCodeSame(404);
    }

    /**
     * @testdox Accessing "/admin/users/{id}/lock" returns an HTTP 200 response.
     */
    public function testLock(): void
    {
        /** @var Proxy<User> $user */
        $user = UserFactory::createOne(['locked' => false]);
        $user
            ->forceSet('id', Uuid::fromRfc4122('8b512428-e0f8-461c-a32e-dbe1cbec5540'))
            ->save();

        $this->client->request('GET', '/admin/users/8b512428-e0f8-461c-a32e-dbe1cbec5540/lock');

        self::assertResponseStatusCodeSame(200);
    }

    /**
     * @testdox Accessing "/admin/users/{id}/lock" with an invalid ID returns an HTTP 404 response.
     */
    public function testLockWithInvalidId(): void
    {
        $this->client->request('GET', '/admin/users/9884f64f-3a49-4e35-a784-87941e9ffbf6/lock');

        self::assertResponseStatusCodeSame(404);
    }

    /**
     * @testdox Accessing "/admin/users/{id}/lock" with an unauthorized user returns an HTTP 403 response.
     */
    public function testLockWithUnauthorizedUser(): void
    {
        $this->client->request('GET', '/admin/users/d025c767-0401-40a1-8a0f-00ae7a08d3e4/lock');

        self::assertResponseStatusCodeSame(403);
    }

    /**
     * @testdox Submitting "/admin/users/{id}/lock" locks the user.
     */
    public function testLockSubmit(): void
    {
        /** @var Proxy<User> $user */
        $user = UserFactory::createOne(['locked' => false]);
        $user
            ->forceSet('id', Uuid::fromRfc4122('9dd9badf-51f2-413d-9da9-4b36d77d1814'))
            ->save();

        $this->client->request('GET', '/admin/users/9dd9badf-51f2-413d-9da9-4b36d77d1814/lock');
        $this->client->submitForm('Lock', serverParameters: ['HTTP_REFERER' => '/admin/users']);
        $this->client->followRedirect();

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('div', 'The user has been locked.');
    }

    /**
     * @testdox Accessing "/admin/users/{id}/unlock" returns an HTTP 200 response.
     */
    public function testUnlock(): void
    {
        /** @var Proxy<User> $user */
        $user = UserFactory::createOne(['locked' => true]);
        $user
            ->forceSet('id', Uuid::fromRfc4122('3db6d43a-17a9-4013-82b3-223556869ba3'))
            ->save();

        $this->client->request('GET', '/admin/users/3db6d43a-17a9-4013-82b3-223556869ba3/unlock');

        self::assertResponseStatusCodeSame(200);
    }

    /**
     * @testdox Accessing "/admin/users/{id}/unlock" with an invalid ID returns an HTTP 404 response.
     */
    public function testUnlockWithInvalidId(): void
    {
        $this->client->request('GET', '/admin/users/5b4e6c08-c9dc-4265-a4b8-04caa6e16c71/unlock');

        self::assertResponseStatusCodeSame(404);
    }

    /**
     * @testdox Accessing "/admin/users/{id}/unlock" with an unauthorized user returns an HTTP 403 response.
     */
    public function testUnlockWithUnauthorizedUser(): void
    {
        $this->client->request('GET', '/admin/users/d025c767-0401-40a1-8a0f-00ae7a08d3e4/unlock');

        self::assertResponseStatusCodeSame(403);
    }

    /**
     * @testdox Submitting "/admin/users/{id}/unlock" unlocks the user.
     */
    public function testUnlockSubmit(): void
    {
        /** @var Proxy<User> $user */
        $user = UserFactory::createOne(['locked' => true]);
        $user
            ->forceSet('id', Uuid::fromRfc4122('d9ebf270-0e9e-40ee-a11c-933642783661'))
            ->save();

        $this->client->request('GET', '/admin/users/d9ebf270-0e9e-40ee-a11c-933642783661/unlock');
        $this->client->submitForm('Unlock', serverParameters: ['HTTP_REFERER' => '/admin/users']);
        $this->client->followRedirect();

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('div', 'The user has been unlocked.');
    }
}
