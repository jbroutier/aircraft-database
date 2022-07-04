<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Interface\IdentifiableInterface;
use App\Entity\Interface\TimestampableInterface;
use App\Entity\Traits\IdentifiableTrait;
use App\Entity\Traits\TimestampableTrait;
use App\Enum\RegistrationMethod;
use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;
use Symfony\Component\Validator\Constraints as Assert;

#[UniqueEntity(fields: ['email'], groups: ['register'])]
#[ORM\Entity(repositoryClass: UserRepository::class)]
class User implements IdentifiableInterface, PasswordAuthenticatedUserInterface, TimestampableInterface, UserInterface
{
    use IdentifiableTrait;
    use TimestampableTrait;

    #[Assert\IsTrue(groups: ['register'])]
    #[ORM\Column(name: 'consenting', type: 'boolean')]
    protected bool $consenting = false;

    #[Assert\NotBlank(groups: ['update_password'])]
    #[UserPassword(groups: ['update_password'])]
    protected ?string $currentPassword = null;

    #[Assert\NotBlank(groups: ['register'])]
    #[Assert\Email(groups: ['register'])]
    #[Assert\Length(max: 180, groups: ['register'])]
    #[ORM\Column(name: 'email', type: 'string', length: 180, unique: true)]
    protected ?string $email = null;

    #[ORM\Column(name: 'enabled', type: 'boolean')]
    protected bool $enabled = false;

    #[Assert\NotBlank(groups: ['register', 'update_profile'])]
    #[Assert\Length(max: 255, groups: ['register', 'update_profile'])]
    #[ORM\Column(name: 'first_name', type: 'string', length: 255)]
    protected ?string $firstName = null;

    #[ORM\Column(name: 'google_id', type: 'string', length: 255, unique: true, nullable: true)]
    protected ?string $googleId = null;

    #[Assert\NotBlank(groups: ['register', 'update_profile'])]
    #[Assert\Length(max: 255, groups: ['register', 'update_profile'])]
    #[ORM\Column(name: 'last_name', type: 'string', length: 255)]
    protected ?string $lastName = null;

    #[ORM\Column(name: 'locked', type: 'boolean')]
    protected bool $locked = false;

    #[ORM\Column(name: 'password', type: 'string', length: 255)]
    protected ?string $password = null;

    #[Assert\NotBlank(groups: ['register', 'reset_password', 'update_password'])]
    #[Assert\NotCompromisedPassword(groups: ['register', 'reset_password', 'update_password'])]
    #[Assert\NotEqualTo(propertyPath: 'email', groups: ['register', 'reset_password', 'update_password'])]
    #[Assert\Length(min: 8, groups: ['register', 'reset_password', 'update_password'])]
    protected ?string $plainPassword = null;

    #[ORM\Column(name: 'registration_method', enumType: RegistrationMethod::class)]
    protected ?RegistrationMethod $registrationMethod = null;

    /**
     * @var string[] $roles
     */
    #[ORM\Column(name: 'roles', type: 'json')]
    protected array $roles = [];

    public function isConsenting(): bool
    {
        return $this->consenting;
    }

    public function setConsenting(bool $consenting): User
    {
        $this->consenting = $consenting;
        return $this;
    }

    public function getCurrentPassword(): ?string
    {
        return $this->currentPassword;
    }

    public function setCurrentPassword(?string $currentPassword): User
    {
        $this->currentPassword = $currentPassword;
        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): User
    {
        $this->email = $email;
        return $this;
    }

    public function isEnabled(): bool
    {
        return $this->enabled;
    }

    public function setEnabled(bool $enabled): User
    {
        $this->enabled = $enabled;
        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(?string $firstName): User
    {
        $this->firstName = $firstName;
        return $this;
    }

    public function getFullName(): string
    {
        return $this->firstName . ' ' . $this->lastName;
    }

    public function getGoogleId(): ?string
    {
        return $this->googleId;
    }

    public function setGoogleId(?string $googleId): User
    {
        $this->googleId = $googleId;
        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(?string $lastName): User
    {
        $this->lastName = $lastName;
        return $this;
    }

    public function isLocked(): bool
    {
        return $this->locked;
    }

    public function setLocked(bool $locked): User
    {
        $this->locked = $locked;
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

    public function getRegistrationMethod(): ?RegistrationMethod
    {
        return $this->registrationMethod;
    }

    public function setRegistrationMethod(?RegistrationMethod $registrationMethod): User
    {
        $this->registrationMethod = $registrationMethod;
        return $this;
    }

    public function getRoles(): array
    {
        $roles = $this->roles;
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param string[] $roles
     */
    public function setRoles(array $roles): User
    {
        $this->roles = $roles;
        return $this;
    }

    public function getUserIdentifier(): string
    {
        return (string)$this->email;
    }

    public function eraseCredentials(): void
    {
        $this->plainPassword = null;
    }
}
