<?php

declare(strict_types=1);

namespace Tests\Unit\Factory;

use App\Factory\PropertyGroupFactory;
use PHPUnit\Framework\TestCase;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\Test\Factories;

final class PropertyGroupFactoryTest extends TestCase
{
    use Factories;

    /**
     * @testdox Method createOne() returns an instance of Proxy<PropertyGroup>.
     */
    public function testCreate(): void
    {
        $propertyGroup = PropertyGroupFactory::createOne();

        self::assertInstanceOf(Proxy::class, $propertyGroup);
    }
}
