<?php

declare(strict_types=1);

namespace Tests\Unit\Factory;

use App\Entity\Property;
use App\Factory\PropertyFactory;
use PHPUnit\Framework\TestCase;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\Test\Factories;

final class PropertyFactoryTest extends TestCase
{
    use Factories;

    /**
     * @testdox Method createOne() returns an instance of Proxy<Property>.
     */
    public function testCreate(): void
    {
        $property = PropertyFactory::createOne();

        self::assertInstanceOf(Proxy::class, $property);
    }

    /**
     * @testdox Method createOne() generates the slug from the name by default.
     */
    public function testCreateWithoutSlug(): void
    {
        /** @var Proxy<Property> $property */
        $property = PropertyFactory::createOne(['name' => 'Fuselage height']);

        self::assertEquals('fuselage-height', $property->getSlug());
    }
}
