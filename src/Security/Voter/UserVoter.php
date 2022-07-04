<?php

declare(strict_types=1);

namespace App\Security\Voter;

use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class UserVoter extends Voter
{
    public const DELETE_USER = 'DELETE_USER';
    public const LOCK_USER = 'LOCK_USER';
    public const UNLOCK_USER = 'UNLOCK_USER';

    protected function supports(string $attribute, mixed $subject): bool
    {
        return in_array($attribute, [self::DELETE_USER, self::LOCK_USER, self::UNLOCK_USER], true)
            && $subject instanceof User;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();

        if (!$user instanceof User || !$subject instanceof User) {
            return false;
        }

        return match ($attribute) {
            self::DELETE_USER => !$user->getId()->equals($subject->getId()),
            self::LOCK_USER => !$user->getId()->equals($subject->getId()) && !$subject->isLocked(),
            self::UNLOCK_USER => !$user->getId()->equals($subject->getId()) && $subject->isLocked(),
            default => false,
        };
    }
}
