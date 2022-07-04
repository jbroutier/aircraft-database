<?php

declare(strict_types=1);

namespace App\Entity\Traits;

use App\Entity\Property;
use App\Entity\PropertyGroup;
use App\Entity\PropertyValue;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

trait PropertiesAwareTrait
{
    /**
     * @var Collection<int, PropertyValue>
     */
    #[Assert\Valid]
    #[ORM\ManyToMany(targetEntity: PropertyValue::class, cascade: ['persist'], orphanRemoval: true)]
    #[ORM\JoinTable]
    #[ORM\JoinColumn(name: 'entity', referencedColumnName: 'id', nullable: false, onDelete: 'CASCADE')]
    #[ORM\InverseJoinColumn(name: 'property_value', referencedColumnName: 'id', unique: true, nullable: false, onDelete: 'CASCADE')]
    protected Collection $propertyValues;

    /**
     * @return Collection<int, Property>
     */
    public function getProperties(): Collection
    {
        $properties = new ArrayCollection();

        foreach ($this->getPropertyValues() as $propertyValue) {
            $property = $propertyValue->getProperty();
            if (!$properties->contains($property)) {
                $properties->add($property);
            }
        }

        return $properties;
    }

    /**
     * @return Collection<int, PropertyGroup>
     */
    public function getPropertyGroups(): Collection
    {
        $propertyGroups = new ArrayCollection();

        foreach ($this->getPropertyValues() as $propertyValue) {
            $propertyGroup = $propertyValue->getPropertyGroup();
            if (!$propertyGroups->contains($propertyGroup)) {
                $propertyGroups->add($propertyGroup);
            }
        }

        return $propertyGroups;
    }

    /**
     * @return Collection<int, PropertyValue>
     */
    public function getPropertyValues(): Collection
    {
        return $this->propertyValues;
    }

    public function addPropertyValue(PropertyValue $propertyValue): self
    {
        if (!$this->propertyValues->contains($propertyValue)) {
            $this->propertyValues->add($propertyValue);
        }

        return $this;
    }

    public function removePropertyValue(PropertyValue $propertyValue): self
    {
        $this->propertyValues->removeElement($propertyValue);
        return $this;
    }

    /**
     * @param PropertyValue[] $propertyValues
     */
    public function setPropertyValues(array $propertyValues): self
    {
        $this->propertyValues = new ArrayCollection($propertyValues);
        return $this;
    }
}
