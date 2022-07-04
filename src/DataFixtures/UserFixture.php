<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Enum\RegistrationMethod;
use App\Factory\UserFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        UserFactory::createMany(25);
        UserFactory::createOne([
            'consenting' => true,
            'email' => 'jeremie.broutier@posteo.net',
            'enabled' => true,
            'firstName' => 'Jérémie',
            'googleId' => null,
            'lastName' => 'Broutier',
            'locked' => false,
            'plainPassword' => 'admin',
            'registrationMethod' => RegistrationMethod::RegistrationForm,
            'roles' => ['ROLE_ADMIN'],
        ]);

        $manager->flush();
    }
}
