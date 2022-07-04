<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Interface\IdentifiableInterface;
use App\Entity\Interface\TimestampableInterface;
use App\Entity\Traits\IdentifiableTrait;
use App\Entity\Traits\TimestampableTrait;
use App\Repository\PropertyValueRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: PropertyValueRepository::class)]
class PropertyValue implements IdentifiableInterface, TimestampableInterface
{
    use IdentifiableTrait;
    use TimestampableTrait;

    #[Assert\NotNull]
    #[ORM\ManyToOne(targetEntity: Property::class, inversedBy: 'propertyValues')]
    #[ORM\JoinColumn(name: 'property', referencedColumnName: 'id', nullable: false, onDelete: 'CASCADE')]
    protected ?Property $property = null;

    #[Assert\NotBlank]
    #[Assert\Length(max: 255)]
    #[ORM\Column(name: 'value', type: 'string', length: 255)]
    protected ?string $value = null;

    public function getProperty(): ?Property
    {
        return $this->property;
    }

    public function setProperty(?Property $property): PropertyValue
    {
        $this->property = $property;
        return $this;
    }

    public function getPropertyGroup(): ?PropertyGroup
    {
        return $this->property?->getPropertyGroup();
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(?string $value): PropertyValue
    {
        $this->value = $value;
        return $this;
    }
}
