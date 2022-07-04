<?php

declare(strict_types=1);

namespace Tests\Unit\Factory;

use App\Entity\Manufacturer;
use App\Factory\ManufacturerFactory;
use PHPUnit\Framework\TestCase;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\Test\Factories;

final class ManufacturerFactoryTest extends TestCase
{
    use Factories;

    /**
     * @testdox Method createOne() returns an instance of Proxy<Manufacturer>.
     */
    public function testCreate(): void
    {
        $manufacturer = ManufacturerFactory::createOne();

        self::assertInstanceOf(Proxy::class, $manufacturer);
    }

    /**
     * @testdox Method createOne() generates the slug from the name by default.
     */
    public function testCreateWithoutSlug(): void
    {
        /** @var Proxy<Manufacturer> $manufacturer */
        $manufacturer = ManufacturerFactory::createOne(['name' => 'Safran Helicopter Engines']);

        self::assertEquals('safran-helicopter-engines', $manufacturer->getSlug());
    }
}
