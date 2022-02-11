<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    public function __construct(protected UserPasswordHasherInterface $userPasswordHasher)
    {
    }

    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user
            ->setPassword($this->userPasswordHasher->hashPassword($user, 'admin'))
            ->setRoles(['ROLE_ADMIN'])
            ->setUsername('admin');

        $manager->persist($user);
        $manager->flush();
    }
}
