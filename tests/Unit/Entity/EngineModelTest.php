<?php

declare(strict_types=1);

namespace Tests\Unit\Entity;

use App\Entity\AircraftModel;
use App\Entity\AircraftType;
use App\Entity\EngineModel;
use App\Entity\Manufacturer;
use App\Enum\EngineFamily;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PHPUnit\Framework\TestCase;

final class EngineModelTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    /**
     * @testdox Method getAircraftModels() returns an empty collection by default.
     */
    public function testGetAircraftModels(): void
    {
        self::assertEmpty((new EngineModel())->getAircraftModels());
    }

    /**
     * @testdox Method addAircraftModel() adds an aircraft model.
     */
    public function testAddAircraftModel(): void
    {
        $aircraftModel = \Mockery::mock(AircraftModel::class);

        $engineModel = (new EngineModel())
            ->addAircraftModel($aircraftModel);

        self::assertCount(1, $engineModel->getAircraftModels());
        self::assertContains($aircraftModel, $engineModel->getAircraftModels());
    }

    /**
     * @testdox Method removeAircraftModel() removes an aircraft model.
     */
    public function testRemoveAircraftModel(): void
    {
        $aircraftModel = \Mockery::mock(AircraftModel::class);

        $engineModel = (new EngineModel())
            ->setAircraftModels([$aircraftModel])
            ->removeAircraftModel($aircraftModel);

        self::assertEmpty($engineModel->getAircraftModels());
    }

    /**
     * @testdox Method setAircraftModels() sets the aircraft models.
     */
    public function testSetAircraftModels(): void
    {
        $aircraftModel = \Mockery::mock(AircraftModel::class);

        $engineModel = (new EngineModel())
            ->setAircraftModels([$aircraftModel]);

        self::assertCount(1, $engineModel->getAircraftModels());
        self::assertContains($aircraftModel, $engineModel->getAircraftModels());
    }

    /**
     * @testdox Method getAircraftTypes() returns an empty collection by default.
     */
    public function testGetAircraftTypes(): void
    {
        self::assertEmpty((new EngineModel())->getAircraftTypes());
    }


    /**
     * @testdox Method addAircraftType() adds an aircraft type.
     */
    public function testAddAircraftType(): void
    {
        $aircraftType = \Mockery::mock(AircraftType::class);

        $engineModel = (new EngineModel())
            ->addAircraftType($aircraftType);

        self::assertCount(1, $engineModel->getAircraftTypes());
        self::assertContains($aircraftType, $engineModel->getAircraftTypes());
    }

    /**
     * @testdox Method removeAircraftType() removes an aircraft type.
     */
    public function testRemoveAircraftType(): void
    {
        $aircraftType = \Mockery::mock(AircraftType::class);

        $engineModel = (new EngineModel())
            ->setAircraftTypes([$aircraftType])
            ->removeAircraftType($aircraftType);

        self::assertEmpty($engineModel->getAircraftTypes());
    }

    /**
     * @testdox Method setAircraftTypes() sets the aircraft types.
     */
    public function testSetAircraftTypes(): void
    {
        $aircraftType = \Mockery::mock(AircraftType::class);

        $engineModel = (new EngineModel())
            ->setAircraftTypes([$aircraftType]);

        self::assertCount(1, $engineModel->getAircraftTypes());
        self::assertContains($aircraftType, $engineModel->getAircraftTypes());
    }

    /**
     * @testdox Method getEngineFamily() returns null by default.
     */
    public function testGetEngineFamily(): void
    {
        self::assertNull((new EngineModel())->getEngineFamily());
    }

    /**
     * @testdox Method setEngineFamily() sets the engine family.
     */
    public function testSetEngineFamily(): void
    {
        $engineModel = (new EngineModel())
            ->setEngineFamily(EngineFamily::Electric);

        self::assertEquals(EngineFamily::Electric, $engineModel->getEngineFamily());
    }

    /**
     * @testdox Method getManufacturer() returns null by default.
     */
    public function testGetManufacturer(): void
    {
        self::assertNull((new EngineModel())->getManufacturer());
    }

    /**
     * @testdox Method setManufacturer() sets the manufacturer.
     */
    public function testSetManufacturer(): void
    {
        $manufacturer = \Mockery::mock(Manufacturer::class);

        $engineModel = (new EngineModel())
            ->setManufacturer($manufacturer);

        self::assertEquals($manufacturer, $engineModel->getManufacturer());
    }

    /**
     * @testdox Method __clone() resets the slug.
     */
    public function testCloneResetsSlug(): void
    {
        $engineModel = (new EngineModel())
            ->setSlug('v-1650-21');

        self::assertNull((clone $engineModel)->getSlug());
    }
}
