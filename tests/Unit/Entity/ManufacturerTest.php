<?php

declare(strict_types=1);

namespace Tests\Unit\Entity;

use App\Entity\AircraftModel;
use App\Entity\AircraftType;
use App\Entity\EngineModel;
use App\Entity\Logo;
use App\Entity\Manufacturer;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PHPUnit\Framework\TestCase;

final class ManufacturerTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    /**
     * @testdox Method getAircraftModels() returns an empty collection by default.
     */
    public function testGetAircraftModels(): void
    {
        self::assertEmpty((new Manufacturer())->getAircraftModels());
    }

    /**
     * @testdox Method addAircraftModel() adds an aircraft model.
     */
    public function testAddAircraftModel(): void
    {
        $manufacturer = new Manufacturer();

        $aircraftModel = \Mockery::mock(AircraftModel::class);
        $aircraftModel
            ->expects('setManufacturer')
            ->once()
            ->with($manufacturer)
            ->andReturnSelf();

        $manufacturer->addAircraftModel($aircraftModel);

        self::assertCount(1, $manufacturer->getAircraftModels());
        self::assertContains($aircraftModel, $manufacturer->getAircraftModels());
    }

    /**
     * @testdox Method removeAircraftModel() removes an aircraft model.
     */
    public function testRemoveAircraftModel(): void
    {
        $aircraftModel = \Mockery::mock(AircraftModel::class);

        $manufacturer = (new Manufacturer())
            ->setAircraftModels([$aircraftModel]);

        $aircraftModel
            ->expects('getManufacturer')
            ->once()
            ->andReturn($manufacturer);

        $aircraftModel
            ->expects('setManufacturer')
            ->once()
            ->with(null)
            ->andReturnSelf();

        $manufacturer->removeAircraftModel($aircraftModel);

        self::assertEmpty($manufacturer->getAircraftModels());
    }

    /**
     * @testdox Method setAircraftModels() sets the aircraft models.
     */
    public function testSetAircraftModels(): void
    {
        $aircraftModel = \Mockery::mock(AircraftModel::class);

        $manufacturer = (new Manufacturer())
            ->setAircraftModels([$aircraftModel]);

        self::assertCount(1, $manufacturer->getAircraftModels());
        self::assertContains($aircraftModel, $manufacturer->getAircraftModels());
    }

    /**
     * @testdox Method getAircraftTypes() returns an empty collection by default.
     */
    public function testGetAircraftTypes(): void
    {
        self::assertEmpty((new Manufacturer())->getAircraftTypes());
    }

    /**
     * @testdox Method addAircraftType() adds an aircraft type.
     */
    public function testAddAircraftType(): void
    {
        $manufacturer = new Manufacturer();

        $aircraftType = \Mockery::mock(AircraftType::class);
        $aircraftType
            ->expects('setManufacturer')
            ->once()
            ->with($manufacturer)
            ->andReturnSelf();

        $manufacturer->addAircraftType($aircraftType);

        self::assertCount(1, $manufacturer->getAircraftTypes());
        self::assertContains($aircraftType, $manufacturer->getAircraftTypes());
    }

    /**
     * @testdox Method removeAircraftType() removes an aircraft type.
     */
    public function testRemoveAircraftType(): void
    {
        $aircraftType = \Mockery::mock(AircraftType::class);

        $manufacturer = new Manufacturer();
        $manufacturer->setAircraftTypes([$aircraftType]);

        $aircraftType
            ->expects('getManufacturer')
            ->once()
            ->andReturn($manufacturer);

        $aircraftType
            ->expects('setManufacturer')
            ->once()
            ->with(null)
            ->andReturnSelf();

        $manufacturer->removeAircraftType($aircraftType);

        self::assertEmpty($manufacturer->getAircraftTypes());
    }

    /**
     * @testdox Method setAircraftTypes() sets the aircraft types.
     */
    public function testSetAircraftTypes(): void
    {
        $aircraftType = \Mockery::mock(AircraftType::class);

        $manufacturer = (new Manufacturer())
            ->setAircraftTypes([$aircraftType]);

        self::assertCount(1, $manufacturer->getAircraftTypes());
        self::assertContains($aircraftType, $manufacturer->getAircraftTypes());
    }

    /**
     * @testdox Method getCountry() returns null by default.
     */
    public function testGetCountry(): void
    {
        self::assertNull((new Manufacturer())->getCountry());
    }

    /**
     * @testdox Method setCountry() sets the country.
     */
    public function testSetCountry(): void
    {
        $manufacturer = (new Manufacturer())
            ->setCountry('FR');

        self::assertEquals('FR', $manufacturer->getCountry());
    }

    /**
     * @testdox Method getEngineModels() returns an empty collection by default.
     */
    public function testGetEngineModels(): void
    {
        self::assertEmpty((new Manufacturer())->getEngineModels());
    }

    /**
     * @testdox Method addEngineModel() adds an engine model.
     */
    public function testAddEngineModel(): void
    {
        $manufacturer = new Manufacturer();

        $engineModel = \Mockery::mock(EngineModel::class);
        $engineModel
            ->expects('setManufacturer')
            ->once()
            ->with($manufacturer)
            ->andReturnSelf();

        $manufacturer->addEngineModel($engineModel);

        self::assertCount(1, $manufacturer->getEngineModels());
        self::assertContains($engineModel, $manufacturer->getEngineModels());
    }

    /**
     * @testdox Method removeEngineModel() removes an engine model.
     */
    public function testRemoveEngineModel(): void
    {
        $engineModel = \Mockery::mock(EngineModel::class);

        $manufacturer = (new Manufacturer())
            ->setEngineModels([$engineModel]);

        $engineModel
            ->expects('getManufacturer')
            ->once()
            ->andReturn($manufacturer);

        $engineModel
            ->expects('setManufacturer')
            ->once()
            ->with(null)
            ->andReturnSelf();

        $manufacturer->removeEngineModel($engineModel);

        self::assertEmpty($manufacturer->getEngineModels());
    }

    /**
     * @testdox Method setEngineModels() sets the engine models.
     */
    public function testSetEngineModels(): void
    {
        $engineModel = \Mockery::mock(EngineModel::class);

        $manufacturer = (new Manufacturer())
            ->setEngineModels([$engineModel]);

        self::assertCount(1, $manufacturer->getEngineModels());
        self::assertContains($engineModel, $manufacturer->getEngineModels());
    }

    /**
     * @testdox Method __clone() resets the logo.
     */
    public function testCloneResetsLogo(): void
    {
        $logo = \Mockery::mock(Logo::class);

        $manufacturer = (new Manufacturer())
            ->setLogo($logo);

        self::assertNull((clone $manufacturer)->getLogo());
    }

    /**
     * @testdox Method __clone() resets the slug.
     */
    public function testCloneResetsSlug(): void
    {
        $manufacturer = (new Manufacturer())
            ->setSlug('messerschmitt');

        self::assertNull((clone $manufacturer)->getSlug());
    }
}
