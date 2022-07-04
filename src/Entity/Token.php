<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Interface\IdentifiableInterface;
use App\Entity\Interface\TimestampableInterface;
use App\Entity\Traits\IdentifiableTrait;
use App\Entity\Traits\TimestampableTrait;
use App\Repository\TokenRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TokenRepository::class)]
class Token implements IdentifiableInterface, TimestampableInterface
{
    use IdentifiableTrait;
    use TimestampableTrait;

    #[ORM\Column(name: 'expires_at', type: 'datetime_immutable')]
    protected ?\DateTimeImmutable $expiresAt = null;

    #[ORM\Column(name: 'role', type: 'string', length: 255)]
    protected ?string $role = null;

    #[ORM\Column(name: 'token', type: 'string', length: 255)]
    protected ?string $token = null;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(name: 'user', referencedColumnName: 'id', onDelete: 'CASCADE')]
    protected ?User $user = null;

    public function getExpiresAt(): ?\DateTimeImmutable
    {
        return $this->expiresAt;
    }

    public function setExpiresAt(?\DateTimeImmutable $expiresAt): Token
    {
        $this->expiresAt = $expiresAt;
        return $this;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(?string $role): Token
    {
        $this->role = $role;
        return $this;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(?string $token): Token
    {
        $this->token = $token;
        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): Token
    {
        $this->user = $user;
        return $this;
    }

    public function isValid(string $expectedRole): bool
    {
        $now = new \DateTimeImmutable('now', new \DateTimeZone('UTC'));
        return $this->role === $expectedRole && $this->expiresAt > $now;
    }
}
