<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\PropertyGroup;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class PropertyGroupFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $generator = Factory::create();

        for ($i = 0; $i < 10; $i++) {
            $propertyGroup = new PropertyGroup();
            $propertyGroup->setName($generator->text(10));

            $manager->persist($propertyGroup);
        }

        $manager->flush();
        $manager->clear();
    }
}
