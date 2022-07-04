<?php

declare(strict_types=1);

namespace App\Security;

use App\Entity\Token;
use App\Entity\User;

class TokenGenerator
{
    public function generate(User $user, string $role, int $ttl): Token
    {
        $now = new \DateTimeImmutable('now', new \DateTimeZone('UTC'));
        $expiresAt = $now->modify(sprintf('+%s second', $ttl));
        $token = bin2hex(openssl_random_pseudo_bytes(16));

        return (new Token())
            ->setExpiresAt($expiresAt)
            ->setRole($role)
            ->setToken($token)
            ->setUser($user);
    }
}
