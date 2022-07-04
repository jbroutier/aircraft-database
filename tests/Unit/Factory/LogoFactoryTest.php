<?php

declare(strict_types=1);

namespace Tests\Unit\Factory;

use App\Factory\LogoFactory;
use PHPUnit\Framework\TestCase;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\Test\Factories;

final class LogoFactoryTest extends TestCase
{
    use Factories;

    /**
     * @testdox Method createOne() returns an instance of Proxy<Logo>.
     */
    public function testCreate(): void
    {
        $logo = LogoFactory::createOne();

        self::assertInstanceOf(Proxy::class, $logo);
    }
}
