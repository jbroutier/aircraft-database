<?php

declare(strict_types=1);

namespace Tests\Functional\Controller\Admin;

use App\Entity\Logo;
use App\Entity\User;
use App\Factory\LogoFactory;
use App\Factory\UserFactory;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Uid\Uuid;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

final class LogoControllerTest extends WebTestCase
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
     * @testdox Accessing "/admin/logos/{id}/delete" deletes the logo.
     */
    public function testDelete(): void
    {
        /** @var Proxy<Logo> $logo */
        $logo = LogoFactory::createOne();
        $logo
            ->forceSet('id', Uuid::fromRfc4122('aadb7eb9-994d-4e36-8df0-5ea2fbc63c25'))
            ->save();

        $this->client->request('GET', '/admin/logos/aadb7eb9-994d-4e36-8df0-5ea2fbc63c25/delete');

        self::assertResponseStatusCodeSame(200);
    }

    /**
     * @testdox Accessing "/admin/logos/{id}/delete" with an invalid ID returns an HTTP 404 response.
     */
    public function testDeleteWithInvalidId(): void
    {
        $this->client->request('GET', '/admin/logos/204a25e7-e468-48bf-bb4a-5f0c3b57d2f7/delete');

        self::assertResponseStatusCodeSame(404);
    }
}
