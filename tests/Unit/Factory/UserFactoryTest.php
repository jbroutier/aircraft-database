<?php

declare(strict_types=1);

namespace Tests\Unit\Factory;

use App\Factory\UserFactory;
use PHPUnit\Framework\TestCase;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\Test\Factories;

final class UserFactoryTest extends TestCase
{
    use Factories;

    /**
     * @testdox Method createOne() returns an instance of Proxy<User>.
     */
    public function testCreate(): void
    {
        $user = UserFactory::createOne();

        self::assertInstanceOf(Proxy::class, $user);
    }
}
