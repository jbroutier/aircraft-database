<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\DataFixtures\Traits\PicturesTrait;
use App\DataFixtures\Traits\PropertiesTrait;
use App\DataFixtures\Traits\TagsTrait;
use App\Entity\AircraftModel;
use App\Entity\AircraftType;
use App\Entity\Manufacturer;
use App\Entity\Property;
use App\Entity\Tag;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AircraftModelFixtures extends Fixture implements DependentFixtureInterface
{
    use PicturesTrait;
    use PropertiesTrait;
    use TagsTrait;

    public function getDependencies(): array
    {
        return [
            AircraftTypeFixtures::class,
            ManufacturerFixtures::class,
            PropertyFixtures::class,
        ];
    }

    public function load(ObjectManager $manager): void
    {
        $generator = Factory::create();

        $pictures = [
            $generator->image(width: 1920, height: 1080, randomize: false, word: 'Picture 1', gray: true),
            $generator->image(width: 1920, height: 1080, randomize: false, word: 'Picture 2', gray: true),
            $generator->image(width: 1920, height: 1080, randomize: false, word: 'Picture 3', gray: true),
            $generator->image(width: 1920, height: 1080, randomize: false, word: 'Picture 4', gray: true),
            $generator->image(width: 1920, height: 1080, randomize: false, word: 'Picture 5', gray: true),
        ];

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

        for ($i = 0; $i < 1000; $i++) {
            $aircraftModel = new AircraftModel();
            $aircraftModel
                ->setAircraftType($generator->optional(0.95)->randomElement($aircraftTypes))
                ->setManufacturer($generator->optional(0.95)->randomElement($manufacturers))
                ->setName($generator->regexify('[A-Z]{1,2}[0-9]{1,3}\-[0-9]{1,4}'))
                ->setSlug($generator->unique()->slug());

            $this->addPictures($generator, $aircraftModel, $pictures);
            $this->addProperties($generator, $aircraftModel, $properties);
            $this->addTags($generator, $aircraftModel, $tags);

            $manager->persist($aircraftModel);
        }

        $manager->flush();
        $manager->clear();
    }
}
