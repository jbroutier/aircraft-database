<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\DataFixtures\Traits\PicturesTrait;
use App\DataFixtures\Traits\PropertiesTrait;
use App\DataFixtures\Traits\TagsTrait;
use App\Entity\AircraftType;
use App\Entity\Manufacturer;
use App\Entity\Property;
use App\Entity\Tag;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AircraftTypeFixtures extends Fixture implements DependentFixtureInterface
{
    use PicturesTrait;
    use PropertiesTrait;
    use TagsTrait;

    public function getDependencies(): array
    {
        return [
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
            $aircraftType = new AircraftType();
            $aircraftType
                ->setIataCode($generator->optional()->regexify('[A-Z0-9]{2,3}'))
                ->setIcaoCode($generator->optional()->regexify('[A-Z0-9]{2,4}'))
                ->setManufacturer($generator->optional(0.95)->randomElement($manufacturers))
                ->setName($generator->regexify('[A-Z]{1,2}[0-9]{1,3}\-[0-9]{1,4}'))
                ->setSlug($generator->unique()->slug());

            $this->addPictures($generator, $aircraftType, $pictures);
            $this->addProperties($generator, $aircraftType, $properties);
            $this->addTags($generator, $aircraftType, $tags);

            $manager->persist($aircraftType);
        }

        $manager->flush();
        $manager->clear();
    }
}
