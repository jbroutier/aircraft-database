<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\PropertyGroup;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\DependencyInjection\Attribute\When;

#[When('dev')]
#[When('test')]
class PropertyGroupFixture extends Fixture implements FixtureGroupInterface
{
    public function load(ObjectManager $manager): void
    {
        $generator = Factory::create();

        for ($i = 0; $i < 10; $i++) {
            $generator->seed($i);

            $propertyGroup = new PropertyGroup();
            $propertyGroup->setName($generator->unique()->word());

            $manager->persist($propertyGroup);
        }

        $manager->flush();
        $manager->clear();
    }

    public static function getGroups(): array
    {
        return ['base', 'full'];
    }
}
