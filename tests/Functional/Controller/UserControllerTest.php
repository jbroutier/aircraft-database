<?php

declare(strict_types=1);

namespace Tests\Functional\Controller;

use App\Entity\User;
use App\Factory\UserFactory;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
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
        $user = UserFactory::createOne(['plainPassword' => '#hQUiE8av!']);
        $this->client->loginUser($user->object());
    }

    /**
     * @testdox Accessing "/user/update-password" returns an HTTP 200 response.
     */
    public function testUpdatePassword(): void
    {
        $this->client->request('GET', '/user/update-password');

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('h1', 'Update password');
    }

    /**
     * @testdox Submitting "/user/update-password" updates the user password.
     */
    public function testUpdatePasswordSubmit(): void
    {
        $this->client->request('GET', '/user/update-password');
        $this->client->submitForm('Update password', [
            'update_password[plainPassword][first]' => '$shMqW7DZ*',
            'update_password[plainPassword][second]' => '$shMqW7DZ*',
            'update_password[currentPassword]' => '#hQUiE8av!',
        ]);

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('div', 'Your password has been updated.');
    }

    /**
     * @testdox Accessing "/user/update-profile" returns an HTTP 200 response.
     */
    public function testUpdateProfile(): void
    {
        $this->client->request('GET', '/user/update-profile');

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('h1', 'Update profile');
    }

    /**
     * @testdox Submitting "/user/update-profile" updates the user profile.
     */
    public function testUpdateProfileSubmit(): void
    {
        $this->client->request('GET', '/user/update-profile');
        $this->client->submitForm('Update profile', [
            'update_profile[firstName]' => 'Jérémie',
            'update_profile[lastName]' => 'Broutier',
        ]);

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('div', 'Your profile has been updated.');
    }
}
