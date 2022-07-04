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

final class AircraftModelTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    /**
     * @testdox Method getAircraftFamily() returns null by default.
     */
    public function testGetAircraftFamily(): void
    {
        self::assertNull((new AircraftModel())->getAircraftFamily());
    }

    /**
     * @testdox Method setAircraftFamily() sets the aircraft family.
     */
    public function testSetAircraftFamily(): void
    {
        $aircraftModel = (new AircraftModel())
            ->setAircraftFamily(AircraftFamily::Airplane);

        self::assertEquals(AircraftFamily::Airplane, $aircraftModel->getAircraftFamily());
    }

    /**
     * @testdox Method getAircraftType() returns null by default.
     */
    public function testGetAircraftType(): void
    {
        self::assertNull((new AircraftModel())->getAircraftType());
    }

    /**
     * @testdox Method setAircraftType() sets the aircraft type.
     */
    public function testSetAircraftType(): void
    {
        $aircraftType = \Mockery::mock(AircraftType::class);

        $aircraftModel = (new AircraftModel())
            ->setAircraftType($aircraftType);

        self::assertEquals($aircraftType, $aircraftModel->getAircraftType());
    }

    /**
     * @testdox Method getEngineCount() returns null by default.
     */
    public function testGetEngineCount(): void
    {
        self::assertNull((new AircraftModel())->getEngineCount());
    }

    /**
     * @testdox Method setEngineCount() sets the engine count.
     */
    public function testSetEngineCount(): void
    {
        $aircraftModel = (new AircraftModel())
            ->setEngineCount(2);

        self::assertEquals(2, $aircraftModel->getEngineCount());
    }

    /**
     * @testdox Method getEngineFamily() returns null by default.
     */
    public function testGetEngineFamily(): void
    {
        self::assertNull((new AircraftModel())->getEngineFamily());
    }

    /**
     * @testdox Method setEngineFamily() sets the engine family.
     */
    public function testSetEngineFamily(): void
    {
        $aircraftModel = (new AircraftModel())
            ->setEngineFamily(EngineFamily::Electric);

        self::assertEquals(EngineFamily::Electric, $aircraftModel->getEngineFamily());
    }

    /**
     * @testdox Method getEngineModels() returns an empty collection by default.
     */
    public function testGetEngineModels(): void
    {
        self::assertEmpty((new AircraftModel())->getEngineModels());
    }

    /**
     * @testdox Method addEngineModel() adds an engine model.
     */
    public function testAddEngineModel(): void
    {
        $engineModel = \Mockery::mock(EngineModel::class);

        $aircraftModel = (new AircraftModel())
            ->addEngineModel($engineModel);

        self::assertCount(1, $aircraftModel->getEngineModels());
        self::assertContains($engineModel, $aircraftModel->getEngineModels());
    }

    /**
     * @testdox Method removeEngineModel() removes an engine model.
     */
    public function testRemoveEngineModel(): void
    {
        $engineModel = \Mockery::mock(EngineModel::class);

        $aircraftModel = (new AircraftModel())
            ->setEngineModels([$engineModel])
            ->removeEngineModel($engineModel);

        self::assertEmpty($aircraftModel->getEngineModels());
    }

    /**
     * @testdox Method setEngineModels() sets the engine models.
     */
    public function testSetEngineModels(): void
    {
        $engineModels = \Mockery::mock(EngineModel::class);

        $aircraftModel = (new AircraftModel())
            ->setEngineModels([$engineModels]);

        self::assertCount(1, $aircraftModel->getEngineModels());
        self::assertContains($engineModels, $aircraftModel->getEngineModels());
    }

    /**
     * @testdox Method getManufacturer() returns null by default.
     */
    public function testGetManufacturer(): void
    {
        self::assertNull((new AircraftModel())->getManufacturer());
    }

    /**
     * @testdox Method setManufacturer() sets the manufacturer.
     */
    public function testSetManufacturer(): void
    {
        $manufacturer = \Mockery::mock(Manufacturer::class);

        $aircraftModel = (new AircraftModel())
            ->setManufacturer($manufacturer);

        self::assertEquals($manufacturer, $aircraftModel->getManufacturer());
    }

    /**
     * @testdox Method __clone() resets the pictures collection.
     */
    public function testCloneResetsPictures(): void
    {
        $picture = \Mockery::mock(Picture::class);

        $aircraftModel = (new AircraftModel())
            ->addPicture($picture);

        self::assertEmpty((clone $aircraftModel)->getPictures());
    }

    /**
     * @testdox Method __clone() resets the slug.
     */
    public function testCloneResetsSlug(): void
    {
        $aircraftModel = (new AircraftModel())
            ->setSlug('c17-globemaster-iii');

        self::assertNull((clone $aircraftModel)->getSlug());
    }
}
