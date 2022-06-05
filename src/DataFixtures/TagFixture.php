<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Tag;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\DependencyInjection\Attribute\When;

#[When('dev')]
#[When('test')]
class TagFixture extends Fixture implements FixtureGroupInterface
{
    public function load(ObjectManager $manager): void
    {
        $generator = Factory::create();

        if (($json = file_get_contents('./res/icons.json')) === false) {
            throw new \RuntimeException('Could not read file "res/icons.json".');
        }

        $icons = json_decode($json, true);

        for ($i = 0; $i < 10; $i++) {
            $generator->seed($i);

            $tag = new Tag();
            $tag
                ->setColor($generator->unique()->hexColor())
                ->setDescription($generator->optional()->sentence())
                ->setIcon($generator->unique()->randomElement($icons))
                ->setName($generator->unique()->word())
                ->setSlug($generator->unique()->slug());

            $manager->persist($tag);
        }

        $manager->flush();
        $manager->clear();
    }

    public static function getGroups(): array
    {
        return ['base', 'full'];
    }
}
