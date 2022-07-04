<?php

declare(strict_types=1);

namespace Tests\Unit\Factory;

use App\Factory\PictureFactory;
use PHPUnit\Framework\TestCase;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\Test\Factories;

final class PictureFactoryTest extends TestCase
{
    use Factories;

    /**
     * @testdox Method createOne() returns an instance of Proxy<Picture>.
     */
    public function testCreate(): void
    {
        $picture = PictureFactory::createOne();

        self::assertInstanceOf(Proxy::class, $picture);
    }
}
