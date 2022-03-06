<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\DataFixtures\Traits\LogoTrait;
use App\DataFixtures\Traits\PropertiesTrait;
use App\DataFixtures\Traits\TagsTrait;
use App\Entity\Manufacturer;
use App\Entity\Property;
use App\Entity\Tag;
use DavidBadura\FakerMarkdownGenerator\FakerProvider;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ManufacturerFixture extends Fixture implements DependentFixtureInterface, FixtureGroupInterface
{
    use LogoTrait;
    use PropertiesTrait;
    use TagsTrait;

    public function getDependencies(): array
    {
        return [
            PropertyFixture::class,
        ];
    }

    public function load(ObjectManager $manager): void
    {
        $generator = Factory::create();
        $generator->addProvider(new FakerProvider($generator));

        $properties = $manager
            ->getRepository(Property::class)
            ->findAll();

        $tags = $manager
            ->getRepository(Tag::class)
            ->findAll();

        for ($i = 0; $i < 10; $i++) {
            $generator->seed($i);

            $manufacturer = new Manufacturer();
            $manufacturer
                /** @phpstan-ignore-next-line */
                ->setContent($generator->optional()->markdown())
                ->setCountry($generator->optional()->countryCode())
                ->setName($generator->unique()->company())
                ->setSlug($generator->unique()->slug());

            $this->setLogo($generator, $manufacturer);
            $this->addProperties($generator, $manufacturer, $properties);
            $this->addTags($generator, $manufacturer, $tags);

            $manager->persist($manufacturer);
        }

        $manager->flush();
        $manager->clear();
    }

    public static function getGroups(): array
    {
        return ['base', 'full'];
    }
}
