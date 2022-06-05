<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Interface\IdentifiableInterface;
use App\Entity\Interface\TimestampableInterface;
use App\Entity\Traits\IdentifiableTrait;
use App\Entity\Traits\TimestampableTrait;
use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User implements IdentifiableInterface, UserInterface, PasswordAuthenticatedUserInterface, TimestampableInterface
{
    use IdentifiableTrait;
    use TimestampableTrait;

    /**
     * @var string|null The username used to authenticate the user.
     */
    #[ORM\Column(name: 'username', type: 'string', length: 180, unique: true)]
    protected ?string $username = null;

    /**
     * @var array<string> The roles granted to the user.
     */
    #[ORM\Column(name: 'roles', type: 'json')]
    protected array $roles = [];

    /**
     * @var string|null The password used to authenticate the user.
     */
    #[ORM\Column(name: 'password', type: 'string', length: 255)]
    protected ?string $password = null;

    /**
     * @var string|null The plain-text password to be hashed.
     */
    protected ?string $plainPassword = null;

    /**
     * @return array<string>
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param array<string> $roles
     */
    public function setRoles(array $roles): User
    {
        $this->roles = $roles;
        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password): User
    {
        $this->password = $password;
        return $this;
    }

    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    public function setPlainPassword(?string $plainPassword): User
    {
        $this->plainPassword = $plainPassword;
        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(?string $username): User
    {
        $this->username = $username;
        return $this;
    }

    public function getUserIdentifier(): string
    {
        return (string)$this->username;
    }

    public function eraseCredentials(): void
    {
        $this->plainPassword = null;
    }
}
