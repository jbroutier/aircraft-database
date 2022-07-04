<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Interface\BlameableInterface;
use App\Entity\Interface\ContentAwareInterface;
use App\Entity\Interface\IdentifiableInterface;
use App\Entity\Interface\NameableInterface;
use App\Entity\Interface\PropertiesAwareInterface;
use App\Entity\Interface\SluggableInterface;
use App\Entity\Interface\TagsAwareInterface;
use App\Entity\Interface\TimestampableInterface;
use App\Entity\Traits\BlameableTrait;
use App\Entity\Traits\ContentAwareTrait;
use App\Entity\Traits\IdentifiableTrait;
use App\Entity\Traits\NameableTrait;
use App\Entity\Traits\PropertiesAwareTrait;
use App\Entity\Traits\SluggableTrait;
use App\Entity\Traits\TagsAwareTrait;
use App\Entity\Traits\TimestampableTrait;
use App\Enum\EngineFamily;
use App\Repository\EngineModelRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[UniqueEntity(['slug'])]
#[ORM\Entity(repositoryClass: EngineModelRepository::class)]
class EngineModel implements BlameableInterface, ContentAwareInterface, IdentifiableInterface, NameableInterface,
                             PropertiesAwareInterface, SluggableInterface, TagsAwareInterface, TimestampableInterface
{
    use BlameableTrait;
    use ContentAwareTrait;
    use IdentifiableTrait;
    use NameableTrait;
    use PropertiesAwareTrait;
    use SluggableTrait;
    use TagsAwareTrait;
    use TimestampableTrait;

    /**
     * @var Collection<int, AircraftModel>
     */
    #[ORM\OrderBy(['name' => 'ASC'])]
    #[ORM\ManyToMany(targetEntity: AircraftModel::class, mappedBy: 'engineModels')]
    protected Collection $aircraftModels;

    /**
     * @var Collection<int, AircraftType>
     */
    #[ORM\OrderBy(['name' => 'ASC'])]
    #[ORM\ManyToMany(targetEntity: AircraftType::class, mappedBy: 'engineModels')]
    protected Collection $aircraftTypes;

    #[Assert\NotNull]
    #[ORM\Column(name: 'engine_family', enumType: EngineFamily::class)]
    protected ?EngineFamily $engineFamily = null;

    #[Assert\NotNull]
    #[ORM\ManyToOne(targetEntity: Manufacturer::class, inversedBy: 'engineModels')]
    #[ORM\JoinColumn(name: 'manufacturer', referencedColumnName: 'id', onDelete: 'SET NULL')]
    protected ?Manufacturer $manufacturer = null;

    public function __construct()
    {
        $this->aircraftModels = new ArrayCollection();
        $this->aircraftTypes = new ArrayCollection();
        $this->propertyValues = new ArrayCollection();
        $this->tags = new ArrayCollection();
    }

    public function __clone()
    {
        $this->slug = null;
    }

    /**
     * @return Collection<int, AircraftModel>
     */
    public function getAircraftModels(): Collection
    {
        return $this->aircraftModels;
    }

    public function addAircraftModel(AircraftModel $aircraftModel): EngineModel
    {
        if (!$this->aircraftModels->contains($aircraftModel)) {
            $this->aircraftModels->add($aircraftModel);
        }

        return $this;
    }

    public function removeAircraftModel(AircraftModel $aircraftModel): EngineModel
    {
        $this->aircraftModels->removeElement($aircraftModel);
        return $this;
    }

    /**
     * @param AircraftModel[] $aircraftModels
     */
    public function setAircraftModels(array $aircraftModels): EngineModel
    {
        $this->aircraftModels = new ArrayCollection($aircraftModels);
        return $this;
    }

    /**
     * @return Collection<int, AircraftType>
     */
    public function getAircraftTypes(): Collection
    {
        return $this->aircraftTypes;
    }

    public function addAircraftType(AircraftType $aircraftType): EngineModel
    {
        if (!$this->aircraftTypes->contains($aircraftType)) {
            $this->aircraftTypes->add($aircraftType);
        }

        return $this;
    }

    public function removeAircraftType(AircraftType $aircraftType): EngineModel
    {
        $this->aircraftTypes->removeElement($aircraftType);
        return $this;
    }

    /**
     * @param AircraftType[] $aircraftTypes
     */
    public function setAircraftTypes(array $aircraftTypes): EngineModel
    {
        $this->aircraftTypes = new ArrayCollection($aircraftTypes);
        return $this;
    }

    public function getEngineFamily(): ?EngineFamily
    {
        return $this->engineFamily;
    }

    public function setEngineFamily(?EngineFamily $engineFamily): EngineModel
    {
        $this->engineFamily = $engineFamily;
        return $this;
    }

    public function getManufacturer(): ?Manufacturer
    {
        return $this->manufacturer;
    }

    public function setManufacturer(?Manufacturer $manufacturer): EngineModel
    {
        $this->manufacturer = $manufacturer;
        return $this;
    }
}
