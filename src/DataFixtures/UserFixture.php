<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\Attribute\When;

#[When('dev')]
#[When('test')]
class UserFixture extends Fixture implements FixtureGroupInterface
{
    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user
            ->setPlainPassword('admin')
            ->setRoles(['ROLE_ADMIN'])
            ->setUsername('admin');

        $manager->persist($user);
        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['base', 'full'];
    }
}
