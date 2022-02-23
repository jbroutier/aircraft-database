<?php

declare(strict_types=1);

namespace Tests\Unit\Entity;

use App\Entity\User;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PHPUnit\Framework\TestCase;

final class UserTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    /**
     * @testdox Method getUsername() returns null by default.
     */
    public function testGetUsername(): void
    {
        $user = new User();

        self::assertNull($user->getUsername());
    }

    /**
     * @testdox Method getUserIdentifier() returns the username.
     */
    public function testGetUserIdentifier(): void
    {
        $user = new User();
        $user->setUsername('manfredvr');

        self::assertEquals('manfredvr', $user->getUserIdentifier());
    }

    /**
     * @testdox Method setUsername() sets the username.
     */
    public function testSetUsername(): void
    {
        $user = new User();
        $user->setUsername('dat_goose_1549');

        self::assertEquals('dat_goose_1549', $user->getUsername());
    }

    /**
     * @testdox Method getRoles() returns the ROLE_USER role by default.
     */
    public function testGetRoles(): void
    {
        $user = new User();

        self::assertEquals(['ROLE_USER'], $user->getRoles());
    }

    /**
     * @testdox Method setRoles() sets the roles.
     */
    public function testSetRoles(): void
    {
        $user = new User();
        $user->setRoles(['ROLE_ADMIN']);

        self::assertEquals(['ROLE_ADMIN', 'ROLE_USER'], $user->getRoles());
    }

    /**
     * @testdox Method getPassword() returns null by default.
     */
    public function testGetPassword(): void
    {
        $user = new User();

        self::assertNull($user->getPassword());
    }

    /**
     * @testdox Method setPassword() sets the password.
     */
    public function testSetPassword(): void
    {
        $user = new User();
        $user->setPassword('notmyrealpassword');

        self::assertEquals('notmyrealpassword', $user->getPassword());
    }
}
