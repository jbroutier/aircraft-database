<?php

declare(strict_types=1);

namespace Tests\Unit\Factory;

use App\Factory\TokenFactory;
use PHPUnit\Framework\TestCase;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\Test\Factories;

final class TokenFactoryTest extends TestCase
{
    use Factories;

    /**
     * @testdox Method createOne() returns an instance of Proxy<Token>.
     */
    public function testCreate(): void
    {
        $token = TokenFactory::createOne();

        self::assertInstanceOf(Proxy::class, $token);
    }
}
