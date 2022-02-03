<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Tag;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class TagFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $generator = Factory::create();

        if (($json = file_get_contents('./res/icons.json')) === false) {
            throw new \RuntimeException('Could not read file "res/icons.json".');
        }

        $icons = json_decode($json, true);

        for ($i = 0; $i < 10; $i++) {
            $tag = new Tag();
            $tag
                ->setColor($generator->hexColor())
                ->setDescription($generator->optional()->text(50))
                ->setIcon($generator->randomElement($icons))
                ->setName($generator->text(10))
                ->setSlug($generator->unique()->slug());

            $manager->persist($tag);
        }

        $manager->flush();
        $manager->clear();
    }
}
