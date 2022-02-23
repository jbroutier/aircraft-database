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

final class EngineModelTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    /**
     * @testdox Method getAircraftModels() returns an empty collection by default.
     */
    public function testGetAircraftModels(): void
    {
        $engineModel = new EngineModel();

        self::assertEmpty($engineModel->getAircraftModels());
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

        $engineModel = new EngineModel();
        $engineModel->setAircraftModels($aircraftModels);

        $paginated = $engineModel
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
        $aircraftModel = \Mockery::mock(AircraftModel::class);

        $engineModel = new EngineModel();
        $engineModel->addAircraftModel($aircraftModel);

        self::assertEquals($aircraftModel, $engineModel->getAircraftModels()->first());
    }

    /**
     * @testdox Method removeAircraftModel() removes an aircraft model.
     */
    public function testRemoveAircraftModel(): void
    {
        $aircraftModel = \Mockery::mock(AircraftModel::class);

        $engineModel = new EngineModel();
        $engineModel
            ->setAircraftModels([$aircraftModel])
            ->removeAircraftModel($aircraftModel);

        self::assertEmpty($engineModel->getAircraftModels());
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

        $engineModel = new EngineModel();
        $engineModel->setAircraftModels($aircraftModels);

        self::assertEquals($aircraftModels, $engineModel->getAircraftModels()->toArray());
    }

    /**
     * @testdox Method getAircraftTypes() returns an empty collection by default.
     */
    public function testGetAircraftTypes(): void
    {
        $engineModel = new EngineModel();

        self::assertEmpty($engineModel->getAircraftTypes());
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

        $engineModel = new EngineModel();
        $engineModel->setAircraftTypes($aircraftTypes);

        $paginated = $engineModel
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
        $aircraftType = \Mockery::mock(AircraftType::class);

        $engineModel = new EngineModel();
        $engineModel->addAircraftType($aircraftType);

        self::assertEquals($aircraftType, $engineModel->getAircraftTypes()->first());
    }

    /**
     * @testdox Method removeAircraftType() removes an aircraft type.
     */
    public function testRemoveAircraftType(): void
    {
        $aircraftType = \Mockery::mock(AircraftType::class);

        $engineModel = new EngineModel();
        $engineModel
            ->setAircraftTypes([$aircraftType])
            ->removeAircraftType($aircraftType);

        self::assertEmpty($engineModel->getAircraftTypes());
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

        $engineModel = new EngineModel();
        $engineModel->setAircraftTypes($aircraftTypes);

        self::assertEquals($aircraftTypes, $engineModel->getAircraftTypes()->toArray());
    }

    /**
     * @testdox Method getManufacturer() returns null by default.
     */
    public function testGetManufacturer(): void
    {
        $engineModel = new EngineModel();

        self::assertNull($engineModel->getManufacturer());
    }

    /**
     * @testdox Method setManufacturer() sets the manufacturer.
     */
    public function testSetManufacturer(): void
    {
        $manufacturer = \Mockery::mock(Manufacturer::class);

        $engineModel = new EngineModel();
        $engineModel->setManufacturer($manufacturer);

        self::assertEquals($manufacturer, $engineModel->getManufacturer());
    }

    /**
     * @testdox Method __clone() resets the pictures collection.
     */
    public function testCloneResetsPictures(): void
    {
        $picture = \Mockery::mock(Picture::class);

        $engineModel = new EngineModel();
        $engineModel->addPicture($picture);

        self::assertEmpty((clone $engineModel)->getPictures());
    }

    /**
     * @testdox Method __clone() resets the slug.
     */
    public function testCloneResetsSlug(): void
    {
        $engineModel = new EngineModel();
        $engineModel->setSlug('lorem-ipsum-dolor-sit-amet');

        self::assertNull((clone $engineModel)->getSlug());
    }
}
