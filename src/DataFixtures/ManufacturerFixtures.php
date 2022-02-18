<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\DataFixtures\Traits\PicturesTrait;
use App\DataFixtures\Traits\PropertiesTrait;
use App\DataFixtures\Traits\TagsTrait;
use App\Entity\Manufacturer;
use App\Entity\Property;
use App\Entity\Tag;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ManufacturerFixtures extends Fixture implements DependentFixtureInterface
{
    use PicturesTrait;
    use PropertiesTrait;
    use TagsTrait;

    public function getDependencies(): array
    {
        return [
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

        $properties = $manager
            ->getRepository(Property::class)
            ->findAll();

        $tags = $manager
            ->getRepository(Tag::class)
            ->findAll();

        for ($i = 0; $i < 100; $i++) {
            $generator->seed($i);

            $manufacturer = new Manufacturer();
            $manufacturer
                ->setCountry($generator->countryCode())
                ->setName($generator->company())
                ->setSlug($generator->unique()->slug());

            $this->addPictures($generator, $manufacturer, $pictures);
            $this->addProperties($generator, $manufacturer, $properties);
            $this->addTags($generator, $manufacturer, $tags);

            $manager->persist($manufacturer);
        }

        $manager->flush();
        $manager->clear();
    }
}
