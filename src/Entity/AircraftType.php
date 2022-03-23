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
use App\Repository\AircraftTypeRepository;
use App\Validator\IataAircraftTypeCode;
use App\Validator\IcaoAircraftTypeCode;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Pagerfanta\Doctrine\Collections\CollectionAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[UniqueEntity(['slug'])]
#[ORM\Entity(repositoryClass: AircraftTypeRepository::class)]
#[ORM\Index(columns: ['content', 'name'], flags: ['fulltext'])]
class AircraftType implements
    BlameableInterface,
    ContentAwareInterface,
    IdentifiableInterface,
    NameableInterface,
    PicturesAwareInterface,
    PropertiesAwareInterface,
    SluggableInterface,
    TagsAwareInterface,
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

    /**
     * @var Collection<int, AircraftModel> The aircraft models which belong to the aircraft type.
     */
    #[ORM\OrderBy(['name' => 'ASC'])]
    #[ORM\OneToMany(mappedBy: 'aircraftType', targetEntity: AircraftModel::class)]
    protected Collection $aircraftModels;

    /**
     * @var Collection<int, EngineModel> The engine models which can be used on the aircraft type.
     */
    #[ORM\OrderBy(['name' => 'ASC'])]
    #[ORM\ManyToMany(targetEntity: EngineModel::class, inversedBy: 'aircraftTypes')]
    #[ORM\JoinTable]
    #[ORM\JoinColumn(name: 'aircraft_type', referencedColumnName: 'id', nullable: false, onDelete: 'CASCADE')]
    #[ORM\InverseJoinColumn(name: 'engine_model', referencedColumnName: 'id', nullable: false, onDelete: 'CASCADE')]
    protected Collection $engineModels;

    /**
     * @var string|null The IATA code of the aircraft type.
     */
    #[IataAircraftTypeCode]
    #[ORM\Column(name: 'iata_code', type: 'string', nullable: true)]
    protected ?string $iataCode = null;

    /**
     * @var string|null The ICAO code of the aircraft type.
     */
    #[IcaoAircraftTypeCode]
    #[ORM\Column(name: 'icao_code', type: 'string', nullable: true)]
    protected ?string $icaoCode = null;

    /**
     * @var Manufacturer|null The manufacturer which builds the aircraft type.
     */
    #[Assert\NotNull]
    #[ORM\ManyToOne(targetEntity: Manufacturer::class, inversedBy: 'aircraftTypes')]
    #[ORM\JoinColumn(name: 'manufacturer', referencedColumnName: 'id', onDelete: 'SET NULL')]
    protected ?Manufacturer $manufacturer = null;

    public function __construct()
    {
        $this->aircraftModels = new ArrayCollection();
        $this->engineModels = new ArrayCollection();
        $this->pictures = new ArrayCollection();
        $this->propertyValues = new ArrayCollection();
        $this->tags = new ArrayCollection();
    }

    public function __clone()
    {
        $this->pictures = new ArrayCollection();
        $this->slug = null;
    }

    /**
     * @return Collection<int, AircraftModel>
     */
    public function getAircraftModels(): Collection
    {
        return $this->aircraftModels;
    }

    /**
     * @return Pagerfanta<AircraftModel>
     */
    public function getAircraftModelsPaginated(): Pagerfanta
    {
        return new Pagerfanta(new CollectionAdapter($this->aircraftModels));
    }

    public function addAircraftModel(AircraftModel $aircraftModel): AircraftType
    {
        if (!$this->aircraftModels->contains($aircraftModel)) {
            $aircraftModel->setAircraftType($this);
            $this->aircraftModels->add($aircraftModel);
        }

        return $this;
    }

    public function removeAircraftModel(AircraftModel $aircraftModel): AircraftType
    {
        $this->aircraftModels->removeElement($aircraftModel);

        if ($aircraftModel->getAircraftType() === $this) {
            $aircraftModel->setAircraftType(null);
        }

        return $this;
    }

    /**
     * @param array<AircraftModel> $aircraftModels
     */
    public function setAircraftModels(array $aircraftModels): AircraftType
    {
        $this->aircraftModels = new ArrayCollection($aircraftModels);
        return $this;
    }

    /**
     * @return Collection<int, EngineModel>
     */
    public function getEngineModels(): Collection
    {
        return $this->engineModels;
    }

    /**
     * @return Pagerfanta<EngineModel>
     */
    public function getEngineModelsPaginated(): Pagerfanta
    {
        return new Pagerfanta(new CollectionAdapter($this->engineModels));
    }

    public function addEngineModel(EngineModel $engineModel): AircraftType
    {
        if (!$this->engineModels->contains($engineModel)) {
            $this->engineModels->add($engineModel);
        }

        return $this;
    }

    public function removeEngineModel(EngineModel $engineModel): AircraftType
    {
        $this->engineModels->removeElement($engineModel);
        return $this;
    }

    /**
     * @param array<EngineModel> $engineModels
     */
    public function setEngineModels(array $engineModels): AircraftType
    {
        $this->engineModels = new ArrayCollection($engineModels);
        return $this;
    }

    public function getIataCode(): ?string
    {
        return $this->iataCode;
    }

    public function setIataCode(?string $iataCode): AircraftType
    {
        $this->iataCode = $iataCode;
        return $this;
    }

    public function getIcaoCode(): ?string
    {
        return $this->icaoCode;
    }

    public function setIcaoCode(?string $icaoCode): AircraftType
    {
        $this->icaoCode = $icaoCode;
        return $this;
    }

    public function getManufacturer(): ?Manufacturer
    {
        return $this->manufacturer;
    }

    public function setManufacturer(?Manufacturer $manufacturer): AircraftType
    {
        $this->manufacturer = $manufacturer;
        return $this;
    }
}
