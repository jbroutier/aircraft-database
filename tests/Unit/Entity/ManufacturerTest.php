<?php

declare(strict_types=1);

namespace Tests\Unit\Entity;

use App\Entity\AircraftModel;
use App\Entity\AircraftType;
use App\Entity\EngineModel;
use App\Entity\Logo;
use App\Entity\Manufacturer;
use App\Entity\Picture;
use PHPUnit\Framework\TestCase;

final class ManufacturerTest extends TestCase
{
    /**
     * @testdox Method getAircraftModels() returns an empty collection by default.
     */
    public function testGetAircraftModels(): void
    {
        $manufacturer = new Manufacturer();

        self::assertEmpty($manufacturer->getAircraftModels());
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

        $manufacturer = new Manufacturer();
        $manufacturer->setAircraftModels($aircraftModels);

        $paginated = $manufacturer
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
        $manufacturer = new Manufacturer();

        $aircraftModel = \Mockery::mock(AircraftModel::class);
        $aircraftModel
            ->expects('setManufacturer')
            ->with($manufacturer)
            ->andReturnSelf();

        $manufacturer->addAircraftModel($aircraftModel);

        self::assertEquals($aircraftModel, $manufacturer->getAircraftModels()->first());
    }

    /**
     * @testdox Method removeAircraftModel() removes an aircraft model.
     */
    public function testRemoveAircraftModel(): void
    {
        $aircraftModel = \Mockery::mock(AircraftModel::class);

        $manufacturer = new Manufacturer();
        $manufacturer->setAircraftModels([$aircraftModel]);

        $aircraftModel
            ->expects('getManufacturer')
            ->andReturn($manufacturer);

        $aircraftModel
            ->expects('setManufacturer')
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
        $aircraftModels = [
            \Mockery::mock(AircraftModel::class),
            \Mockery::mock(AircraftModel::class),
        ];

        $manufacturer = new Manufacturer();
        $manufacturer->setAircraftModels($aircraftModels);

        self::assertEquals($aircraftModels, $manufacturer->getAircraftModels()->toArray());
    }

    /**
     * @testdox Method getAircraftTypes() returns an empty collection by default.
     */
    public function testGetAircraftTypes(): void
    {
        $manufacturer = new Manufacturer();

        self::assertEmpty($manufacturer->getAircraftTypes());
    }

    /**
     * @testdox Method getAircraftTypesPaginated() returns the aircraft types as a paginated collection.
     */
    public function testGetAircraftTypesPaginated(): void
    {
        $aircraftTypes = [
            \Mockery::mock(AircraftType::class),
            \Mockery::mock(AircraftType::class),
            \Mockery::mock(AircraftType::class),
        ];

        $manufacturer = new Manufacturer();
        $manufacturer->setAircraftTypes($aircraftTypes);

        $paginated = $manufacturer
            ->getAircraftTypesPaginated()
            ->setMaxPerPage(2);

        self::assertEquals(3, $paginated->getNbResults());
        self::assertEquals(2, $paginated->getNbPages());
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
            ->with($manufacturer)
            ->andReturnSelf();

        $manufacturer->addAircraftType($aircraftType);

        self::assertEquals($aircraftType, $manufacturer->getAircraftTypes()->first());
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
            ->andReturn($manufacturer);

        $aircraftType
            ->expects('setManufacturer')
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
        $aircraftTypes = [
            \Mockery::mock(AircraftType::class),
            \Mockery::mock(AircraftType::class),
        ];

        $manufacturer = new Manufacturer();
        $manufacturer->setAircraftTypes($aircraftTypes);

        self::assertEquals($aircraftTypes, $manufacturer->getAircraftTypes()->toArray());
    }

    /**
     * @testdox Method getCountry() returns null by default.
     */
    public function testGetCountry(): void
    {
        $manufacturer = new Manufacturer();

        self::assertNull($manufacturer->getCountry());
    }

    /**
     * @testdox Method setCountry() sets the country.
     */
    public function testSetCountry(): void
    {
        $manufacturer = new Manufacturer();
        $manufacturer->setCountry('fr');

        self::assertEquals('fr', $manufacturer->getCountry());
    }

    /**
     * @testdox Method getEngineModels() returns an empty collection by default.
     */
    public function testGetEngineModels(): void
    {
        $manufacturer = new Manufacturer();

        self::assertEmpty($manufacturer->getEngineModels());
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

        $manufacturer = new Manufacturer();
        $manufacturer->setEngineModels($engineModels);

        $paginated = $manufacturer
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
        $manufacturer = new Manufacturer();

        $engineModel = \Mockery::mock(EngineModel::class);
        $engineModel
            ->expects('setManufacturer')
            ->with($manufacturer)
            ->andReturnSelf();

        $manufacturer->addEngineModel($engineModel);

        self::assertEquals($engineModel, $manufacturer->getEngineModels()->first());
    }

    /**
     * @testdox Method removeEngineModel() removes an engine model.
     */
    public function testRemoveEngineModel(): void
    {
        $engineModel = \Mockery::mock(EngineModel::class);

        $manufacturer = new Manufacturer();
        $manufacturer->setEngineModels([$engineModel]);

        $engineModel
            ->expects('getManufacturer')
            ->andReturn($manufacturer);

        $engineModel
            ->expects('setManufacturer')
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
        $engineModels = [
            \Mockery::mock(EngineModel::class),
            \Mockery::mock(EngineModel::class),
        ];

        $manufacturer = new Manufacturer();
        $manufacturer->setEngineModels($engineModels);

        self::assertEquals($engineModels, $manufacturer->getEngineModels()->toArray());
    }

    /**
     * @testdox Method __clone() resets the logo.
     */
    public function testCloneResetsLogo(): void
    {
        $logo = \Mockery::mock(Logo::class);

        $manufacturer = new Manufacturer();
        $manufacturer->setLogo($logo);

        self::assertNull((clone $manufacturer)->getLogo());
    }

    /**
     * @testdox Method __clone() resets the pictures collection.
     */
    public function testCloneResetsPictures(): void
    {
        $picture = \Mockery::mock(Picture::class);

        $manufacturer = new Manufacturer();
        $manufacturer->addPicture($picture);

        self::assertEmpty((clone $manufacturer)->getPictures());
    }

    /**
     * @testdox Method __clone() resets the slug.
     */
    public function testCloneResetsSlug(): void
    {
        $manufacturer = new Manufacturer();
        $manufacturer->setSlug('lorem-ipsum-dolor-sit-amet');

        self::assertNull((clone $manufacturer)->getSlug());
    }
}
