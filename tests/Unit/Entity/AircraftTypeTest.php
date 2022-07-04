<?php

declare(strict_types=1);

namespace Tests\Unit\Entity;

use App\Entity\AircraftModel;
use App\Entity\AircraftType;
use App\Entity\EngineModel;
use App\Entity\Manufacturer;
use App\Entity\Picture;
use App\Enum\AircraftFamily;
use App\Enum\EngineFamily;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PHPUnit\Framework\TestCase;

final class AircraftTypeTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    /**
     * @testdox Method getAircraftFamily() returns null by default.
     */
    public function testGetAircraftFamily(): void
    {
        self::assertNull((new AircraftType())->getAircraftFamily());
    }

    /**
     * @testdox Method setAircraftFamily() sets the aircraft family.
     */
    public function testSetAircraftFamily(): void
    {
        $aircraftType = (new AircraftType())
            ->setAircraftFamily(AircraftFamily::Airplane);

        self::assertEquals(AircraftFamily::Airplane, $aircraftType->getAircraftFamily());
    }

    /**
     * @testdox Method getAircraftModels() returns an empty collection by default.
     */
    public function testGetAircraftModels(): void
    {
        self::assertEmpty((new AircraftType())->getAircraftModels());
    }

    /**
     * @testdox Method addAircraftModel() adds an aircraft model.
     */
    public function testAddAircraftModel(): void
    {
        $aircraftType = new AircraftType();

        $aircraftModel = \Mockery::mock(AircraftModel::class);
        $aircraftModel
            ->expects('setAircraftType')
            ->once()
            ->with($aircraftType)
            ->andReturnSelf();

        $aircraftType->addAircraftModel($aircraftModel);

        self::assertCount(1, $aircraftType->getAircraftModels());
        self::assertContains($aircraftModel, $aircraftType->getAircraftModels());
    }

    /**
     * @testdox Method removeAircraftModel() removes an aircraft model.
     */
    public function testRemoveAircraftModel(): void
    {
        $aircraftModel = \Mockery::mock(AircraftModel::class);

        $aircraftType = (new AircraftType())
            ->setAircraftModels([$aircraftModel]);

        $aircraftModel
            ->expects('getAircraftType')
            ->once()
            ->andReturn($aircraftType);

        $aircraftModel
            ->expects('setAircraftType')
            ->once()
            ->with(null)
            ->andReturnSelf();

        $aircraftType->removeAircraftModel($aircraftModel);

        self::assertEmpty($aircraftType->getAircraftModels());
    }

    /**
     * @testdox Method setAircraftModels() sets the aircraft models.
     */
    public function testSetAircraftModels(): void
    {
        $aircraftModel = \Mockery::mock(AircraftModel::class);

        $aircraftType = (new AircraftType())
            ->setAircraftModels([$aircraftModel]);

        self::assertCount(1, $aircraftType->getAircraftModels());
        self::assertContains($aircraftModel, $aircraftType->getAircraftModels());
    }

    /**
     * @testdox Method getEngineCount() returns null by default.
     */
    public function testGetEngineCount(): void
    {
        self::assertNull((new AircraftType())->getEngineCount());
    }

    /**
     * @testdox Method setEngineCount() sets the engine count.
     */
    public function testSetEngineCount(): void
    {
        $aircraftType = (new AircraftType())
            ->setEngineCount(2);

        self::assertEquals(2, $aircraftType->getEngineCount());
    }

    /**
     * @testdox Method getEngineFamily() returns null by default.
     */
    public function testGetEngineFamily(): void
    {
        self::assertNull((new AircraftType())->getEngineFamily());
    }

    /**
     * @testdox Method setEngineFamily() sets the engine family.
     */
    public function testSetEngineFamily(): void
    {
        $aircraftType = (new AircraftType())
            ->setEngineFamily(EngineFamily::Electric);

        self::assertEquals(EngineFamily::Electric, $aircraftType->getEngineFamily());
    }

    /**
     * @testdox Method getEngineModels() returns an empty collection by default.
     */
    public function testGetEngineModels(): void
    {
        self::assertEmpty((new AircraftType())->getEngineModels());
    }

    /**
     * @testdox Method addEngineModel() adds an engine model.
     */
    public function testAddEngineModel(): void
    {
        $engineModel = \Mockery::mock(EngineModel::class);

        $aircraftType = (new AircraftType())
            ->addEngineModel($engineModel);

        self::assertCount(1, $aircraftType->getEngineModels());
        self::assertContains($engineModel, $aircraftType->getEngineModels());
    }

    /**
     * @testdox Method removeEngineModel() removes an engine model.
     */
    public function testRemoveEngineModel(): void
    {
        $engineModel = \Mockery::mock(EngineModel::class);

        $aircraftType = new AircraftType();
        $aircraftType
            ->setEngineModels([$engineModel])
            ->removeEngineModel($engineModel);

        self::assertEmpty($aircraftType->getEngineModels());
    }

    /**
     * @testdox Method setEngineModels() sets the engine models.
     */
    public function testSetEngineModels(): void
    {
        $engineModel = \Mockery::mock(EngineModel::class);

        $aircraftType = (new AircraftType())
            ->setEngineModels([$engineModel]);

        self::assertCount(1, $aircraftType->getEngineModels());
        self::assertContains($engineModel, $aircraftType->getEngineModels());
    }

    /**
     * @testdox Method getIataCode() returns null by default.
     */
    public function testGetIataCode(): void
    {
        self::assertNull((new AircraftType())->getIataCode());
    }

    /**
     * @testdox Method setIataCode() sets the IATA code.
     */
    public function testSetIataCode(): void
    {
        $aircraftType = (new AircraftType())
            ->setIataCode('342');

        self::assertEquals('342', $aircraftType->getIataCode());
    }

    /**
     * @testdox Method getIcaoCode() returns null by default.
     */
    public function testGetIcaoCode(): void
    {
        self::assertNull((new AircraftType())->getIcaoCode());
    }

    /**
     * @testdox Method setIcaoCode() sets the ICAO code.
     */
    public function testSetIcaoCode(): void
    {
        $aircraftType = (new AircraftType())
            ->setIcaoCode('BE17');

        self::assertEquals('BE17', $aircraftType->getIcaoCode());
    }

    /**
     * @testdox Method getManufacturer() returns null by default.
     */
    public function testGetManufacturer(): void
    {
        self::assertNull((new AircraftType())->getManufacturer());
    }

    /**
     * @testdox Method setManufacturer() sets the manufacturer.
     */
    public function testSetManufacturer(): void
    {
        $manufacturer = \Mockery::mock(Manufacturer::class);

        $aircraftType = (new AircraftType())
            ->setManufacturer($manufacturer);

        self::assertEquals($manufacturer, $aircraftType->getManufacturer());
    }

    /**
     * @testdox Method __clone() resets the pictures collection.
     */
    public function testCloneResetsPictures(): void
    {
        $picture = \Mockery::mock(Picture::class);

        $aircraftType = (new AircraftType())
            ->addPicture($picture);

        self::assertEmpty((clone $aircraftType)->getPictures());
    }

    /**
     * @testdox Method __clone() resets the slug.
     */
    public function testCloneResetsSlug(): void
    {
        $aircraftType = (new AircraftType())
            ->setSlug('v-173-flying-pancake');

        self::assertNull((clone $aircraftType)->getSlug());
    }
}
