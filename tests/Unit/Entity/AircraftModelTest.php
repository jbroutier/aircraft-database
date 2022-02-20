<?php

declare(strict_types=1);

namespace Tests\Unit\Entity;

use App\Entity\AircraftModel;
use App\Entity\AircraftType;
use App\Entity\EngineModel;
use App\Entity\Manufacturer;
use App\Entity\Picture;
use PHPUnit\Framework\TestCase;

final class AircraftModelTest extends TestCase
{
    /**
     * @testdox Method getAircraftType() returns null by default.
     */
    public function testGetAircraftType(): void
    {
        $aircraftModel = new AircraftModel();

        self::assertNull($aircraftModel->getAircraftType());
    }

    /**
     * @testdox Method setAircraftType() sets the aircraft type.
     */
    public function testSetAircraftType(): void
    {
        $aircraftType = \Mockery::mock(AircraftType::class);

        $aircraftModel = new AircraftModel();
        $aircraftModel->setAircraftType($aircraftType);

        self::assertEquals($aircraftType, $aircraftModel->getAircraftType());
    }

    /**
     * @testdox Method getEngineModels() returns an empty collection by default.
     */
    public function testGetEngineModels(): void
    {
        $aircraftModel = new AircraftModel();

        self::assertEmpty($aircraftModel->getEngineModels());
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

        $aircraftModel = new AircraftModel();
        $aircraftModel->setEngineModels($engineModels);

        $paginated = $aircraftModel
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
        $aircraftModel = new AircraftModel();

        $engineModel = \Mockery::mock(EngineModel::class);
        $engineModel
            ->expects('setAircraftModel')
            ->with($aircraftModel)
            ->andReturnSelf();

        $aircraftModel->addEngineModel($engineModel);

        self::assertEquals($engineModel, $aircraftModel->getEngineModels()->first());
    }

    /**
     * @testdox Method removeEngineModel() removes an engine model.
     */
    public function testRemoveEngineModel(): void
    {
        $engineModel = \Mockery::mock(EngineModel::class);

        $aircraftModel = new AircraftModel();
        $aircraftModel->setEngineModels([$engineModel]);

        $engineModel
            ->expects('getAircraftModel')
            ->andReturn($aircraftModel);

        $engineModel
            ->expects('setAircraftModel')
            ->with(null)
            ->andReturnSelf();

        $aircraftModel->removeEngineModel($engineModel);

        self::assertEmpty($aircraftModel->getEngineModels());
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

        $aircraftModel = new AircraftModel();
        $aircraftModel->setEngineModels($engineModels);

        self::assertEquals($engineModels, $aircraftModel->getEngineModels()->toArray());
    }

    /**
     * @testdox Method getManufacturer() returns null by default.
     */
    public function testGetManufacturer(): void
    {
        $aircraftModel = new AircraftModel();

        self::assertNull($aircraftModel->getManufacturer());
    }

    /**
     * @testdox Method setManufacturer() sets the manufacturer.
     */
    public function testSetManufacturer(): void
    {
        $manufacturer = \Mockery::mock(Manufacturer::class);

        $aircraftModel = new AircraftModel();
        $aircraftModel->setManufacturer($manufacturer);

        self::assertEquals($manufacturer, $aircraftModel->getManufacturer());
    }

    /**
     * @testdox Method __clone() resets the pictures collection.
     */
    public function testCloneResetsPictures(): void
    {
        $picture = \Mockery::mock(Picture::class);

        $aircraftModel = new AircraftModel();
        $aircraftModel->addPicture($picture);

        self::assertEmpty((clone $aircraftModel)->getPictures());
    }

    /**
     * @testdox Method __clone() resets the slug.
     */
    public function testCloneResetsSlug(): void
    {
        $aircraftModel = new AircraftModel();
        $aircraftModel->setSlug('lorem-ipsum-dolor-sit-amet');

        self::assertNull((clone $aircraftModel)->getSlug());
    }
}
