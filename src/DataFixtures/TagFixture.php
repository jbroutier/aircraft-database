<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Factory\TagFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TagFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        TagFactory::createMany(25);

        $manager->flush();
    }
}
