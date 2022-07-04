<?php

declare(strict_types=1);

namespace Tests\Unit\Factory;

use App\Entity\AircraftType;
use App\Factory\AircraftTypeFactory;
use PHPUnit\Framework\TestCase;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\Test\Factories;

final class AircraftTypeFactoryTest extends TestCase
{
    use Factories;

    /**
     * @testdox Method createOne() returns an instance of Proxy<AircraftType>.
     */
    public function testCreate(): void
    {
        $aircraftType = AircraftTypeFactory::createOne();

        self::assertInstanceOf(Proxy::class, $aircraftType);
    }

    /**
     * @testdox Method createOne() generates the slug from the name by default.
     */
    public function testCreateWithoutSlug(): void
    {
        /** @var Proxy<AircraftType> $aircraftType */
        $aircraftType = AircraftTypeFactory::createOne(['name' => '727-100RE Super 27']);

        self::assertEquals('727-100re-super-27', $aircraftType->getSlug());
    }
}
