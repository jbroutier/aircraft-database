<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Property;
use App\Entity\PropertyGroup;
use App\Enum\PropertyType;
use App\Enum\PropertyUnit;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\DependencyInjection\Attribute\When;

#[When('dev')]
#[When('test')]
class PropertyFixture extends Fixture implements DependentFixtureInterface, FixtureGroupInterface
{
    public function getDependencies(): array
    {
        return [
            PropertyGroupFixture::class,
        ];
    }

    public function load(ObjectManager $manager): void
    {
        $generator = Factory::create();

        $propertyGroups = $manager
            ->getRepository(PropertyGroup::class)
            ->findAll();

        for ($i = 0; $i < 100; $i++) {
            $generator->seed($i);

            $property = new Property();
            $property
                ->setDescription($generator->optional()->text(50))
                ->setName($generator->unique()->word())
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

    public static function getGroups(): array
    {
        return ['base', 'full'];
    }
}
