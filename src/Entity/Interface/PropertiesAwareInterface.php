<?php

declare(strict_types=1);

namespace App\Entity\Interface;

use App\Entity\PropertyGroup;
use App\Entity\PropertyValue;
use Doctrine\Common\Collections\Collection;

interface PropertiesAwareInterface
{
    /**
     * @return Collection<int, PropertyGroup>
     */
    public function getPropertyGroups(): Collection;

    /**
     * @return Collection<int, PropertyValue>
     */
    public function getPropertyValues(): Collection;

    public function addPropertyValue(PropertyValue $propertyValue): self;

    public function removePropertyValue(PropertyValue $propertyValue): self;
}
