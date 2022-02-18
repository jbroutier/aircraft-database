<?php

declare(strict_types=1);

namespace Tests\Functional\Controller\Traits;

use App\Repository\UserRepository;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

trait FixturesAwareTrait
{
    abstract protected static function getContainer(): ContainerInterface;

    protected function getUser(string $username): UserInterface
    {
        /** @var UserRepository */
        $userRepository = self::getContainer()->get(UserRepository::class);

        if (is_null($user = $userRepository->findOneBy(['username' => $username]))) {
            throw new \RuntimeException('User could not be found.');
        }

        return $user;
    }
}
