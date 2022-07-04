<?php

declare(strict_types=1);

namespace Tests\Unit\Entity;

use App\Entity\Token;
use App\Entity\User;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PHPUnit\Framework\TestCase;

final class TokenTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    /**
     * @testdox Method getExpiresAt() returns null by default.
     */
    public function testGetExpiresAt(): void
    {
        self::assertNull((new Token())->getExpiresAt());
    }

    /**
     * @testdox Method setExpiresAt() sets the expiration date and time.
     */
    public function testSetExpiresAt(): void
    {
        $expiresAt = new \DateTimeImmutable();

        $token = (new Token())
            ->setExpiresAt($expiresAt);

        self::assertEquals($expiresAt, $token->getExpiresAt());
    }

    /**
     * @testdox Method getRole() returns null by default.
     */
    public function testGetRole(): void
    {
        self::assertNull((new Token())->getRole());
    }

    /**
     * @testdox Method setRole() sets the role.
     */
    public function testSetRole(): void
    {
        $token = (new Token())
            ->setRole('register');

        self::assertEquals('register', $token->getRole());
    }

    /**
     * @testdox Method getToken() returns null by default.
     */
    public function testGetToken(): void
    {
        self::assertNull((new Token())->getToken());
    }

    /**
     * @testdox Method setToken() sets the token.
     */
    public function testSetToken(): void
    {
        $token = (new Token())
            ->setToken('3bf16d0c1fcd403b80d5a206c3edb1fd');

        self::assertEquals('3bf16d0c1fcd403b80d5a206c3edb1fd', $token->getToken());
    }

    /**
     * @testdox Method getUser() returns null by default.
     */
    public function testGetUser(): void
    {
        self::assertNull((new Token())->getUser());
    }

    /**
     * @testdox Method setUser() sets the user.
     */
    public function testSetUser(): void
    {
        $user = \Mockery::mock(User::class);
        $token = (new Token())
            ->setUser($user);

        self::assertEquals($user, $token->getUser());
    }
}
