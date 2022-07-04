<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Factory\EngineModelFactory;
use App\Factory\ManufacturerFactory;
use App\Factory\PropertyFactory;
use App\Factory\PropertyValueFactory;
use App\Factory\TagFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class EngineModelFixture extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        EngineModelFactory::createMany(25, fn() => [
            'manufacturer' => ManufacturerFactory::random(),
            'propertyValues' => PropertyValueFactory::createMany(10, fn() => [
                'property' => PropertyFactory::random(),
            ]),
            'tags' => TagFactory::randomRange(0, 1),
        ]);

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            ManufacturerFixture::class,
            PropertyFixture::class,
            TagFixture::class,
        ];
    }
}
