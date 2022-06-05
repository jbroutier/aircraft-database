<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\DataFixtures\Traits\PropertiesTrait;
use App\DataFixtures\Traits\TagsTrait;
use App\Entity\AircraftModel;
use App\Entity\AircraftType;
use App\Entity\Manufacturer;
use App\Entity\Property;
use App\Entity\Tag;
use DavidBadura\FakerMarkdownGenerator\FakerProvider;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\DependencyInjection\Attribute\When;

#[When('dev')]
#[When('test')]
class AircraftModelFixture extends Fixture implements DependentFixtureInterface, FixtureGroupInterface
{
    use PropertiesTrait;
    use TagsTrait;

    public function getDependencies(): array
    {
        return [
            AircraftTypeFixture::class,
            ManufacturerFixture::class,
            PropertyFixture::class,
        ];
    }

    public function load(ObjectManager $manager): void
    {
        $generator = Factory::create();
        $generator->addProvider(new FakerProvider($generator));

        $aircraftTypes = $manager
            ->getRepository(AircraftType::class)
            ->findAll();

        $manufacturers = $manager
            ->getRepository(Manufacturer::class)
            ->findAll();

        $properties = $manager
            ->getRepository(Property::class)
            ->findAll();

        $tags = $manager
            ->getRepository(Tag::class)
            ->findAll();

        for ($i = 0; $i < 100; $i++) {
            $generator->seed($i);

            $aircraftModel = new AircraftModel();
            $aircraftModel
                ->setAircraftType($generator->optional(0.95)->randomElement($aircraftTypes))
                /** @phpstan-ignore-next-line */
                ->setContent($generator->optional()->markdown())
                ->setManufacturer($generator->optional(0.95)->randomElement($manufacturers))
                ->setName($generator->regexify('[A-Z]{1,2}[0-9]{1,3}\-[0-9]{1,4}'))
                ->setSlug($generator->unique()->slug());

            $this->addProperties($generator, $aircraftModel, $properties);
            $this->addTags($generator, $aircraftModel, $tags);

            $manager->persist($aircraftModel);
        }

        $manager->flush();
        $manager->clear();
    }

    public static function getGroups(): array
    {
        return ['base', 'full'];
    }
}
