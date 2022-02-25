<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Interface\BlameableInterface;
use App\Entity\Interface\ContentAwareInterface;
use App\Entity\Interface\IdentifiableInterface;
use App\Entity\Interface\LogoAwareInterface;
use App\Entity\Interface\NameableInterface;
use App\Entity\Interface\PicturesAwareInterface;
use App\Entity\Interface\PropertiesAwareInterface;
use App\Entity\Interface\SluggableInterface;
use App\Entity\Interface\TagsAwareInterface;
use App\Entity\Interface\TimestampableInterface;
use App\Entity\Traits\BlameableTrait;
use App\Entity\Traits\ContentAwareTrait;
use App\Entity\Traits\IdentifiableTrait;
use App\Entity\Traits\LogoAwareTrait;
use App\Entity\Traits\NameableTrait;
use App\Entity\Traits\PicturesAwareTrait;
use App\Entity\Traits\PropertiesAwareTrait;
use App\Entity\Traits\SluggableTrait;
use App\Entity\Traits\TagsAwareTrait;
use App\Entity\Traits\TimestampableTrait;
use App\Repository\ManufacturerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Pagerfanta\Doctrine\Collections\CollectionAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[UniqueEntity(['slug'])]
#[ORM\Entity(repositoryClass: ManufacturerRepository::class)]
class Manufacturer implements
    BlameableInterface,
    ContentAwareInterface,
    IdentifiableInterface,
    LogoAwareInterface,
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
    use LogoAwareTrait;
    use NameableTrait;
    use PicturesAwareTrait;
    use PropertiesAwareTrait;
    use SluggableTrait;
    use TagsAwareTrait;
    use TimestampableTrait;

    /**
     * @var Collection<int, AircraftModel> The aircraft models built by the manufacturer.
     */
    #[ORM\OrderBy(['name' => 'ASC'])]
    #[ORM\OneToMany(mappedBy: 'manufacturer', targetEntity: AircraftModel::class)]
    protected Collection $aircraftModels;

    /**
     * @var Collection<int, AircraftType> The aircraft types built by the manufacturer.
     */
    #[ORM\OrderBy(['name' => 'ASC'])]
    #[ORM\OneToMany(mappedBy: 'manufacturer', targetEntity: AircraftType::class)]
    protected Collection $aircraftTypes;

    /**
     * @var string|null The country of origin of the manufacturer, as an ISO 3166 alpha 2 country code.
     */
    #[Assert\NotBlank]
    #[Assert\Country]
    #[ORM\Column(name: 'country', type: 'string', length: 2)]
    protected ?string $country = null;

    /**
     * @var Collection<int, EngineModel> The engine models build by the manufacturer.
     */
    #[ORM\OrderBy(['name' => 'ASC'])]
    #[ORM\OneToMany(mappedBy: 'manufacturer', targetEntity: EngineModel::class)]
    protected Collection $engineModels;

    public function __construct()
    {
        $this->aircraftModels = new ArrayCollection();
        $this->aircraftTypes = new ArrayCollection();
        $this->engineModels = new ArrayCollection();
        $this->pictures = new ArrayCollection();
        $this->propertyValues = new ArrayCollection();
        $this->tags = new ArrayCollection();
    }

    public function __clone()
    {
        $this->logo = null;
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

    public function addAircraftModel(AircraftModel $aircraftModel): Manufacturer
    {
        if (!$this->aircraftModels->contains($aircraftModel)) {
            $aircraftModel->setManufacturer($this);
            $this->aircraftModels->add($aircraftModel);
        }

        return $this;
    }

    public function removeAircraftModel(AircraftModel $aircraftModel): Manufacturer
    {
        $this->aircraftModels->removeElement($aircraftModel);

        if ($aircraftModel->getManufacturer() === $this) {
            $aircraftModel->setManufacturer(null);
        }

        return $this;
    }

    /**
     * @param array<AircraftModel> $aircraftModels
     */
    public function setAircraftModels(array $aircraftModels): Manufacturer
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

    /**
     * @return Pagerfanta<AircraftType>
     */
    public function getAircraftTypesPaginated(): Pagerfanta
    {
        return new Pagerfanta(new CollectionAdapter($this->aircraftTypes));
    }

    public function addAircraftType(AircraftType $aircraftType): Manufacturer
    {
        if (!$this->aircraftTypes->contains($aircraftType)) {
            $aircraftType->setManufacturer($this);
            $this->aircraftTypes->add($aircraftType);
        }

        return $this;
    }

    public function removeAircraftType(AircraftType $aircraftType): Manufacturer
    {
        $this->aircraftTypes->removeElement($aircraftType);

        if ($aircraftType->getManufacturer() === $this) {
            $aircraftType->setManufacturer(null);
        }

        return $this;
    }

    /**
     * @param array<AircraftType> $aircraftTypes
     */
    public function setAircraftTypes(array $aircraftTypes): Manufacturer
    {
        $this->aircraftTypes = new ArrayCollection($aircraftTypes);
        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(?string $country): Manufacturer
    {
        $this->country = $country;
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

    public function addEngineModel(EngineModel $engineModel): Manufacturer
    {
        if (!$this->engineModels->contains($engineModel)) {
            $engineModel->setManufacturer($this);
            $this->engineModels->add($engineModel);
        }

        return $this;
    }

    public function removeEngineModel(EngineModel $engineModel): Manufacturer
    {
        $this->engineModels->removeElement($engineModel);

        if ($engineModel->getManufacturer() === $this) {
            $engineModel->setManufacturer(null);
        }

        return $this;
    }

    /**
     * @param array<EngineModel> $engineModels
     */
    public function setEngineModels(array $engineModels): Manufacturer
    {
        $this->engineModels = new ArrayCollection($engineModels);
        return $this;
    }
}
