<?php

declare(strict_types=1);

namespace Tests\Unit\Factory;

use App\Entity\AircraftModel;
use App\Factory\AircraftModelFactory;
use PHPUnit\Framework\TestCase;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\Test\Factories;

final class AircraftModelFactoryTest extends TestCase
{
    use Factories;

    /**
     * @testdox Method createOne() returns an instance of Proxy<AircraftModel>.
     */
    public function testCreate(): void
    {
        $aircraftModel = AircraftModelFactory::createOne();

        self::assertInstanceOf(Proxy::class, $aircraftModel);
    }

    /**
     * @testdox Method createOne() generates the slug from the name by default.
     */
    public function testCreateWithoutSlug(): void
    {
        /** @var Proxy<AircraftModel> $aircraftModel */
        $aircraftModel = AircraftModelFactory::createOne(['name' => '707-138B Short Body']);

        self::assertEquals('707-138b-short-body', $aircraftModel->getSlug());
    }
}
