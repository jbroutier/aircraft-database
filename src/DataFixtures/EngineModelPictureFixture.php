<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\DataFixtures\Traits\PicturesTrait;
use App\Entity\EngineModel;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\DependencyInjection\Attribute\When;

#[When('dev')]
#[When('test')]
class EngineModelPictureFixture extends Fixture implements DependentFixtureInterface, FixtureGroupInterface
{
    use PicturesTrait;

    public function getDependencies(): array
    {
        return [
            EngineModelFixture::class,
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

        $engineModels = $manager
            ->getRepository(EngineModel::class)
            ->findAll();

        foreach ($engineModels as $engineModel) {
            $this->addPictures($generator, $engineModel, $pictures);
            $manager->persist($engineModel);
        }

        $manager->flush();
        $manager->clear();
    }

    public static function getGroups(): array
    {
        return ['full'];
    }
}
