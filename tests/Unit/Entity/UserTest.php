<?php

declare(strict_types=1);

namespace Tests\Unit\Entity;

use App\Entity\User;
use App\Enum\RegistrationMethod;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PHPUnit\Framework\TestCase;

final class UserTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    /**
     * @testdox Method isConsenting() returns false by default.
     */
    public function testIsConsenting(): void
    {
        self::assertFalse((new User())->isConsenting());
    }

    /**
     * @testdox Method isConsenting() sets whether the user is consenting.
     */
    public function testSetConsenting(): void
    {
        $user = (new User())
            ->setConsenting(true);

        self::assertTrue($user->isConsenting());
    }

    /**
     * @testdox Method getCurrentPassword() returns null by default.
     */
    public function testGetCurrentPassword(): void
    {
        self::assertNull((new User())->getCurrentPassword());
    }

    /**
     * @testdox Method setCurrentPassword() sets the current password.
     */
    public function testSetCurrentPassword(): void
    {
        $user = (new User())
            ->setCurrentPassword('LPSkAo37!');

        self::assertEquals('LPSkAo37!', $user->getCurrentPassword());
    }

    /**
     * @testdox Method getEmail() returns null by default.
     */
    public function testGetEmail(): void
    {
        self::assertNull((new User())->getEmail());
    }

    /**
     * @testdox Method setEmail() sets the email.
     */
    public function testSetEmail(): void
    {
        $user = (new User())
            ->setEmail('lee.ratke73@yahoo.com');

        self::assertEquals('lee.ratke73@yahoo.com', $user->getEmail());
    }

    /**
     * @testdox Method isEnabled() returns false by default.
     */
    public function testIsEnabled(): void
    {
        self::assertFalse((new User())->isEnabled());
    }

    /**
     * @testdox Method setEnabled() sets whether the user is enabled.
     */
    public function testSetEnabled(): void
    {
        $user = (new User())
            ->setEnabled(true);

        self::assertTrue($user->isEnabled());
    }

    /**
     * @testdox Method getFirstName() returns null by default.
     */
    public function testGetFirstName(): void
    {
        self::assertNull((new User())->getFirstName());
    }

    /**
     * @testdox Method setFirstName() sets the first name.
     */
    public function testSetFirstName(): void
    {
        $user = (new User())
            ->setFirstName('Edwardo');

        self::assertEquals('Edwardo', $user->getFirstName());
    }

    /**
     * @testdox Method getFullName() returns the full name.
     */
    public function testGetFullName(): void
    {
        $user = (new User())
            ->setFirstName('Whitley')
            ->setLastName('Laliotis');

        self::assertEquals('Whitley Laliotis', $user->getFullName());
    }

    /**
     * @testdox Method getGoogleId() returns null by default.
     */
    public function testGetGoogleId(): void
    {
        self::assertNull((new User())->getGoogleId());
    }

    /**
     * @testdox Method setGoogleId() sets the Google account ID.
     */
    public function testSetGoogleId(): void
    {
        $user = (new User())
            ->setGoogleId('4f22e620f7bc');

        self::assertEquals('4f22e620f7bc', $user->getGoogleId());
    }

    /**
     * @testdox Method getGoogleId() returns null by default.
     */
    public function testGetLastName(): void
    {
        self::assertNull((new User())->getLastName());
    }

    /**
     * @testdox Method setLastName() sets the last name.
     */
    public function testSetLastName(): void
    {
        $user = (new User())
            ->setLastName('Berri');

        self::assertEquals('Berri', $user->getLastName());
    }

    /**
     * @testdox Method isLocked() returns false by default.
     */
    public function testIsLocked(): void
    {
        self::assertFalse((new User())->isLocked());
    }

    /**
     * @testdox Method setLocked() sets whether the user is locked.
     */
    public function testSetLocked(): void
    {
        $user = (new User())
            ->setLocked(true);

        self::assertTrue($user->isLocked());
    }

    /**
     * @testdox Method getPassword() returns null by default.
     */
    public function testGetPassword(): void
    {
        self::assertNull((new User())->getPassword());
    }

    /**
     * @testdox Method setPassword() sets the password.
     */
    public function testSetPassword(): void
    {
        $user = (new User())
            ->setPassword('$argon2id$v=19$m=16,t=2,p=1$bm9uZXJlYWxseQ$8/ns1hRjYjU6hxwNWTHa+g');

        self::assertEquals('$argon2id$v=19$m=16,t=2,p=1$bm9uZXJlYWxseQ$8/ns1hRjYjU6hxwNWTHa+g', $user->getPassword());
    }

    /**
     * @testdox Method getPlainPassword() returns null by default.
     */
    public function testGetPlainPassword(): void
    {
        self::assertNull((new User())->getPlainPassword());
    }

    /**
     * @testdox Method setPlainPassword() sets the plain-text password.
     */
    public function testSetPlainPassword(): void
    {
        $user = (new User())
            ->setPlainPassword('#rSeK9VPT');

        self::assertEquals('#rSeK9VPT', $user->getPlainPassword());
    }

    /**
     * @testdox Method getRegistrationMethod() returns null by default.
     */
    public function testGetRegistrationMethod(): void
    {
        self::assertNull((new User())->getRegistrationMethod());
    }

    /**
     * @testdox Method setRegistrationMethod() sets the registration method.
     */
    public function testSetRegistrationMethod(): void
    {
        $user = (new User())
            ->setRegistrationMethod(RegistrationMethod::RegistrationForm);

        self::assertEquals(RegistrationMethod::RegistrationForm, $user->getRegistrationMethod());
    }

    /**
     * @testdox Method getRoles() returns the ROLE_USER role by default.
     */
    public function testGetRoles(): void
    {
        self::assertEquals(['ROLE_USER'], (new User())->getRoles());
    }

    /**
     * @testdox Method setRoles() sets the roles.
     */
    public function testSetRoles(): void
    {
        $user = (new User())
            ->setRoles(['ROLE_ADMIN']);

        self::assertEquals(['ROLE_ADMIN', 'ROLE_USER'], $user->getRoles());
    }

    /**
     * @testdox Method getUserIdentifier() returns the email.
     */
    public function testGetUserIdentifier(): void
    {
        $user = (new User())
            ->setEmail('jaclyn33@gmail.com');

        self::assertEquals('jaclyn33@gmail.com', $user->getUserIdentifier());
    }

    /**
     * @testdox Method eraseCredentials() erases the plain-text password.
     */
    public function testEraseCredentials(): void
    {
        $user = (new User())
            ->setPlainPassword('zY8qqDD3!');
        $user->eraseCredentials();

        self::assertNull($user->getPlainPassword());
    }
}
