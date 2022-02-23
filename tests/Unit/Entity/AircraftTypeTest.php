<?php

declare(strict_types=1);

namespace Tests\Unit\Entity;

use App\Entity\AircraftModel;
use App\Entity\AircraftType;
use App\Entity\EngineModel;
use App\Entity\Manufacturer;
use App\Entity\Picture;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PHPUnit\Framework\TestCase;

final class AircraftTypeTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    /**
     * @testdox Method getAircraftModels() returns an empty collection by default.
     */
    public function testGetAircraftModels(): void
    {
        $aircraftType = new AircraftType();

        self::assertEmpty($aircraftType->getAircraftModels());
    }

    /**
     * @testdox Method getAircraftModelsPaginated() returns the aircraft models as a paginated collection.
     */
    public function testGetAircraftModelsPaginated(): void
    {
        $aircraftModels = [
            \Mockery::mock(AircraftModel::class),
            \Mockery::mock(AircraftModel::class),
            \Mockery::mock(AircraftModel::class),
        ];

        $aircraftType = new AircraftType();
        $aircraftType->setAircraftModels($aircraftModels);

        $paginated = $aircraftType
            ->getAircraftModelsPaginated()
            ->setMaxPerPage(2);

        self::assertEquals(3, $paginated->getNbResults());
        self::assertEquals(2, $paginated->getNbPages());
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

        self::assertEquals($aircraftModel, $aircraftType->getAircraftModels()->first());
    }

    /**
     * @testdox Method removeAircraftModel() removes an aircraft model.
     */
    public function testRemoveAircraftModel(): void
    {
        $aircraftModel = \Mockery::mock(AircraftModel::class);

        $aircraftType = new AircraftType();
        $aircraftType->setAircraftModels([$aircraftModel]);

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
        $aircraftModels = [
            \Mockery::mock(AircraftModel::class),
            \Mockery::mock(AircraftModel::class),
        ];

        $aircraftType = new AircraftType();
        $aircraftType->setAircraftModels($aircraftModels);

        self::assertEquals($aircraftModels, $aircraftType->getAircraftModels()->toArray());
    }

    /**
     * @testdox Method getEngineModels() returns an empty collection by default.
     */
    public function testGetEngineModels(): void
    {
        $aircraftType = new AircraftType();

        self::assertEmpty($aircraftType->getEngineModels());
    }

    /**
     * @testdox Method getEngineModelsPaginated() returns the engine models as a paginated collection.
     */
    public function testGetEngineModelsPaginated(): void
    {
        $engineModels = [
            \Mockery::mock(EngineModel::class),
            \Mockery::mock(EngineModel::class),
            \Mockery::mock(EngineModel::class),
        ];

        $aircraftType = new AircraftType();
        $aircraftType->setEngineModels($engineModels);

        $paginated = $aircraftType
            ->getEngineModelsPaginated()
            ->setMaxPerPage(2);

        self::assertEquals(3, $paginated->getNbResults());
        self::assertEquals(2, $paginated->getNbPages());
    }

    /**
     * @testdox Method addEngineModel() adds an engine model.
     */
    public function testAddEngineModel(): void
    {
        $engineModel = \Mockery::mock(EngineModel::class);

        $aircraftType = new AircraftType();
        $aircraftType->addEngineModel($engineModel);

        self::assertEquals($engineModel, $aircraftType->getEngineModels()->first());
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
        $engineModels = [
            \Mockery::mock(EngineModel::class),
            \Mockery::mock(EngineModel::class),
        ];

        $aircraftType = new AircraftType();
        $aircraftType->setEngineModels($engineModels);

        self::assertEquals($engineModels, $aircraftType->getEngineModels()->toArray());
    }

    /**
     * @testdox Method getIataCode() returns null by default.
     */
    public function testGetIataCode(): void
    {
        $aircraftType = new AircraftType();

        self::assertNull($aircraftType->getIataCode());
    }

    /**
     * @testdox Method setIataCode() sets the IATA code.
     */
    public function testSetIataCode(): void
    {
        $aircraftType = new AircraftType();
        $aircraftType->setIataCode('AT4');

        self::assertEquals('AT4', $aircraftType->getIataCode());
    }

    /**
     * @testdox Method getIcaoCode() returns null by default.
     */
    public function testGetIcaoCode(): void
    {
        $aircraftType = new AircraftType();

        self::assertNull($aircraftType->getIcaoCode());
    }

    /**
     * @testdox Method setIcaoCode() sets the ICAO code.
     */
    public function testSetIcaoCode(): void
    {
        $aircraftType = new AircraftType();
        $aircraftType->setIcaoCode('A20N');

        self::assertEquals('A20N', $aircraftType->getIcaoCode());
    }

    /**
     * @testdox Method getManufacturer() returns null by default.
     */
    public function testGetManufacturer(): void
    {
        $aircraftType = new AircraftType();

        self::assertNull($aircraftType->getManufacturer());
    }

    /**
     * @testdox Method setManufacturer() sets the manufacturer.
     */
    public function testSetManufacturer(): void
    {
        $manufacturer = \Mockery::mock(Manufacturer::class);

        $aircraftType = new AircraftType();
        $aircraftType->setManufacturer($manufacturer);

        self::assertEquals($manufacturer, $aircraftType->getManufacturer());
    }

    /**
     * @testdox Method __clone() resets the pictures collection.
     */
    public function testCloneResetsPictures(): void
    {
        $picture = \Mockery::mock(Picture::class);

        $aircraftType = new AircraftType();
        $aircraftType->addPicture($picture);

        self::assertEmpty((clone $aircraftType)->getPictures());
    }

    /**
     * @testdox Method __clone() resets the slug.
     */
    public function testCloneResetsSlug(): void
    {
        $aircraftType = new AircraftType();
        $aircraftType->setSlug('lorem-ipsum-dolor-sit-amet');

        self::assertNull((clone $aircraftType)->getSlug());
    }
}
