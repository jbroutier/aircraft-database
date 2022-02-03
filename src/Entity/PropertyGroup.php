<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Interface\BlameableInterface;
use App\Entity\Interface\IdentifiableInterface;
use App\Entity\Interface\NameableInterface;
use App\Entity\Interface\TimestampableInterface;
use App\Entity\Traits\BlameableTrait;
use App\Entity\Traits\IdentifiableTrait;
use App\Entity\Traits\NameableTrait;
use App\Entity\Traits\TimestampableTrait;
use App\Repository\PropertyGroupRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PropertyGroupRepository::class)]
class PropertyGroup implements BlameableInterface, IdentifiableInterface, NameableInterface, TimestampableInterface
{
    use BlameableTrait;
    use IdentifiableTrait;
    use NameableTrait;
    use TimestampableTrait;

    /**
     * @var Collection<int, Property>
     */
    #[ORM\OrderBy(['name' => 'ASC'])]
    #[ORM\OneToMany(mappedBy: 'propertyGroup', targetEntity: Property::class, cascade: ['persist'])]
    protected Collection $properties;

    public function __construct()
    {
        $this->properties = new ArrayCollection();
    }

    /**
     * @return Collection<int, Property>
     */
    public function getProperties(): Collection
    {
        return $this->properties;
    }

    public function addProperty(Property $property): PropertyGroup
    {
        if (!$this->properties->contains($property)) {
            $property->setPropertyGroup($this);
            $this->properties->add($property);
        }

        return $this;
    }

    public function removeProperty(Property $property): PropertyGroup
    {
        $this->properties->removeElement($property);

        if ($property->getPropertyGroup() === $this) {
            $property->setPropertyGroup(null);
        }

        return $this;
    }
}
