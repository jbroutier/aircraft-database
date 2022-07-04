<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Factory\PropertyFactory;
use App\Factory\PropertyGroupFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class PropertyFixture extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        PropertyFactory::createMany(25, fn() => [
            'propertyGroup' => PropertyGroupFactory::random(),
        ]);

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            PropertyGroupFixture::class,
        ];
    }
}
