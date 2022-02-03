<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Property;
use App\Entity\PropertyGroup;
use App\Enum\PropertyType;
use App\Enum\PropertyUnit;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class PropertyFixtures extends Fixture implements DependentFixtureInterface
{
    public function getDependencies(): array
    {
        return [
            PropertyGroupFixtures::class,
        ];
    }

    public function load(ObjectManager $manager): void
    {
        $generator = Factory::create();

        $propertyGroups = $manager
            ->getRepository(PropertyGroup::class)
            ->findAll();

        for ($i = 0; $i < 100; $i++) {
            $property = new Property();
            $property
                ->setDescription($generator->optional()->text(50))
                ->setName($generator->text(10))
                ->setPropertyGroup($generator->randomElement($propertyGroups))
                ->setType($generator->randomElement(PropertyType::cases()))
                ->setSlug($generator->unique()->slug());

            if (in_array($property->getType(), [PropertyType::Float, PropertyType::Integer], true)) {
                $property->setUnit($generator->optional()->randomElement(PropertyUnit::cases()));
            }

            $manager->persist($property);
        }

        $manager->flush();
        $manager->clear();
    }
}
