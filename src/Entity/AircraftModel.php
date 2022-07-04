<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Interface\BlameableInterface;
use App\Entity\Interface\ContentAwareInterface;
use App\Entity\Interface\IdentifiableInterface;
use App\Entity\Interface\NameableInterface;
use App\Entity\Interface\PicturesAwareInterface;
use App\Entity\Interface\PropertiesAwareInterface;
use App\Entity\Interface\SluggableInterface;
use App\Entity\Interface\TagsAwareInterface;
use App\Entity\Interface\TimestampableInterface;
use App\Entity\Traits\BlameableTrait;
use App\Entity\Traits\ContentAwareTrait;
use App\Entity\Traits\IdentifiableTrait;
use App\Entity\Traits\NameableTrait;
use App\Entity\Traits\PicturesAwareTrait;
use App\Entity\Traits\PropertiesAwareTrait;
use App\Entity\Traits\SluggableTrait;
use App\Entity\Traits\TagsAwareTrait;
use App\Entity\Traits\TimestampableTrait;
use App\Enum\AircraftFamily;
use App\Enum\EngineFamily;
use App\Repository\AircraftModelRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[UniqueEntity(['slug'])]
#[ORM\Entity(repositoryClass: AircraftModelRepository::class)]
class AircraftModel implements BlameableInterface, ContentAwareInterface, IdentifiableInterface, NameableInterface,
                               PicturesAwareInterface, PropertiesAwareInterface, SluggableInterface, TagsAwareInterface,
                               TimestampableInterface
{
    use BlameableTrait;
    use ContentAwareTrait;
    use IdentifiableTrait;
    use NameableTrait;
    use PicturesAwareTrait;
    use PropertiesAwareTrait;
    use SluggableTrait;
    use TagsAwareTrait;
    use TimestampableTrait;

    #[Assert\NotNull]
    #[ORM\Column(name: 'aircraft_family', enumType: AircraftFamily::class)]
    protected ?AircraftFamily $aircraftFamily = null;

    #[Assert\NotNull]
    #[ORM\ManyToOne(targetEntity: AircraftType::class, inversedBy: 'aircraftModels')]
    #[ORM\JoinColumn(name: 'aircraft_type', referencedColumnName: 'id', onDelete: 'SET NULL')]
    protected ?AircraftType $aircraftType = null;

    #[Assert\NotNull]
    #[Assert\PositiveOrZero]
    #[ORM\Column(name: 'engine_count', type: 'integer')]
    protected ?int $engineCount = null;

    #[Assert\NotNull]
    #[ORM\Column(name: 'engine_family', enumType: EngineFamily::class)]
    protected ?EngineFamily $engineFamily = null;

    /**
     * @var Collection<int, EngineModel>
     */
    #[ORM\OrderBy(['name' => 'ASC'])]
    #[ORM\ManyToMany(targetEntity: EngineModel::class, inversedBy: 'aircraftModels')]
    #[ORM\JoinTable]
    #[ORM\JoinColumn(name: 'aircraft_model', referencedColumnName: 'id', nullable: false, onDelete: 'CASCADE')]
    #[ORM\InverseJoinColumn(name: 'engine_model', referencedColumnName: 'id', nullable: false, onDelete: 'CASCADE')]
    protected Collection $engineModels;

    #[Assert\NotNull]
    #[ORM\ManyToOne(targetEntity: Manufacturer::class, inversedBy: 'aircraftModels')]
    #[ORM\JoinColumn(name: 'manufacturer', referencedColumnName: 'id', onDelete: 'SET NULL')]
    protected ?Manufacturer $manufacturer = null;

    public function __construct()
    {
        $this->engineModels = new ArrayCollection();
        $this->propertyValues = new ArrayCollection();
        $this->pictures = new ArrayCollection();
        $this->tags = new ArrayCollection();
    }

    public function __clone()
    {
        $this->pictures = new ArrayCollection();
        $this->slug = null;
    }

    public function getAircraftFamily(): ?AircraftFamily
    {
        return $this->aircraftFamily;
    }

    public function setAircraftFamily(?AircraftFamily $aircraftFamily): AircraftModel
    {
        $this->aircraftFamily = $aircraftFamily;
        return $this;
    }

    public function getAircraftType(): ?AircraftType
    {
        return $this->aircraftType;
    }

    public function setAircraftType(?AircraftType $aircraftType): AircraftModel
    {
        $this->aircraftType = $aircraftType;
        return $this;
    }

    public function getEngineCount(): ?int
    {
        return $this->engineCount;
    }

    public function setEngineCount(?int $engineCount): AircraftModel
    {
        $this->engineCount = $engineCount;
        return $this;
    }

    public function getEngineFamily(): ?EngineFamily
    {
        return $this->engineFamily;
    }

    public function setEngineFamily(?EngineFamily $engineFamily): AircraftModel
    {
        $this->engineFamily = $engineFamily;
        return $this;
    }

    /**
     * @return Collection<int, EngineModel>
     */
    public function getEngineModels(): Collection
    {
        return $this->engineModels;
    }

    public function addEngineModel(EngineModel $engineModel): AircraftModel
    {
        if (!$this->engineModels->contains($engineModel)) {
            $this->engineModels->add($engineModel);
        }

        return $this;
    }

    public function removeEngineModel(EngineModel $engineModel): AircraftModel
    {
        $this->engineModels->removeElement($engineModel);
        return $this;
    }

    /**
     * @param EngineModel[] $engineModels
     */
    public function setEngineModels(array $engineModels): AircraftModel
    {
        $this->engineModels = new ArrayCollection($engineModels);
        return $this;
    }

    public function getManufacturer(): ?Manufacturer
    {
        return $this->manufacturer;
    }

    public function setManufacturer(?Manufacturer $manufacturer): AircraftModel
    {
        $this->manufacturer = $manufacturer;
        return $this;
    }
}
