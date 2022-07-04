<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Factory\PropertyGroupFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class PropertyGroupFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        PropertyGroupFactory::createMany(25);

        $manager->flush();
    }
}
