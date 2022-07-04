<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Interface\BlameableInterface;
use App\Entity\Interface\DescriptionAwareInterface;
use App\Entity\Interface\IdentifiableInterface;
use App\Entity\Interface\NameableInterface;
use App\Entity\Interface\SluggableInterface;
use App\Entity\Interface\TimestampableInterface;
use App\Entity\Traits\BlameableTrait;
use App\Entity\Traits\DescriptionAwareTrait;
use App\Entity\Traits\IdentifiableTrait;
use App\Entity\Traits\NameableTrait;
use App\Entity\Traits\SluggableTrait;
use App\Entity\Traits\TimestampableTrait;
use App\Enum\PropertyType;
use App\Enum\PropertyUnit;
use App\Repository\PropertyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[UniqueEntity(['slug'])]
#[ORM\Entity(repositoryClass: PropertyRepository::class)]
class Property implements BlameableInterface, DescriptionAwareInterface, IdentifiableInterface, NameableInterface,
                          SluggableInterface, TimestampableInterface
{
    use BlameableTrait;
    use DescriptionAwareTrait;
    use IdentifiableTrait;
    use NameableTrait;
    use SluggableTrait;
    use TimestampableTrait;

    #[Assert\NotNull]
    #[ORM\ManyToOne(targetEntity: PropertyGroup::class, inversedBy: 'properties')]
    #[ORM\JoinColumn(name: 'property_group', referencedColumnName: 'id', onDelete: 'SET NULL')]
    protected ?PropertyGroup $propertyGroup = null;

    /**
     * @var Collection<int, PropertyValue>
     */
    #[ORM\OneToMany(mappedBy: 'property', targetEntity: PropertyValue::class)]
    protected Collection $propertyValues;

    #[Assert\NotNull]
    #[ORM\Column(name: 'type', enumType: PropertyType::class)]
    protected ?PropertyType $type = null;

    #[ORM\Column(name: 'unit', nullable: true, enumType: PropertyUnit::class)]
    protected ?PropertyUnit $unit = null;

    public function __construct()
    {
        $this->propertyValues = new ArrayCollection();
    }

    public function getPropertyGroup(): ?PropertyGroup
    {
        return $this->propertyGroup;
    }

    public function setPropertyGroup(?PropertyGroup $propertyGroup): Property
    {
        $this->propertyGroup = $propertyGroup;
        return $this;
    }

    /**
     * @return Collection<int, PropertyValue>
     */
    public function getPropertyValues(): Collection
    {
        return $this->propertyValues;
    }

    public function addPropertyValue(PropertyValue $propertyValue): Property
    {
        if (!$this->propertyValues->contains($propertyValue)) {
            $propertyValue->setProperty($this);
            $this->propertyValues->add($propertyValue);
        }

        return $this;
    }

    public function removePropertyValue(PropertyValue $propertyValue): Property
    {
        $this->propertyValues->removeElement($propertyValue);

        if ($propertyValue->getProperty() === $this) {
            $propertyValue->setProperty(null);
        }

        return $this;
    }

    /**
     * @param PropertyValue[] $propertyValues
     */
    public function setPropertyValues(array $propertyValues): Property
    {
        $this->propertyValues = new ArrayCollection($propertyValues);
        return $this;
    }

    public function getType(): ?PropertyType
    {
        return $this->type;
    }

    public function setType(?PropertyType $type): Property
    {
        $this->type = $type;
        return $this;
    }

    public function getUnit(): ?PropertyUnit
    {
        return $this->unit;
    }

    public function setUnit(?PropertyUnit $unit): Property
    {
        $this->unit = $unit;
        return $this;
    }
}
