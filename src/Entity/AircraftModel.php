<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Interface\BlameableInterface;
use App\Entity\Interface\IdentifiableInterface;
use App\Entity\Interface\NameableInterface;
use App\Entity\Interface\PicturesAwareInterface;
use App\Entity\Interface\PropertiesAwareInterface;
use App\Entity\Interface\SluggableInterface;
use App\Entity\Interface\TagsAwareInterface;
use App\Entity\Interface\TimestampableInterface;
use App\Entity\Traits\BlameableTrait;
use App\Entity\Traits\IdentifiableTrait;
use App\Entity\Traits\NameableTrait;
use App\Entity\Traits\PicturesAwareTrait;
use App\Entity\Traits\PropertiesAwareTrait;
use App\Entity\Traits\SluggableTrait;
use App\Entity\Traits\TagsAwareTrait;
use App\Entity\Traits\TimestampableTrait;
use App\Repository\AircraftModelRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Pagerfanta\Doctrine\Collections\CollectionAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: AircraftModelRepository::class)]
class AircraftModel implements
    BlameableInterface,
    IdentifiableInterface,
    NameableInterface,
    PicturesAwareInterface,
    PropertiesAwareInterface,
    SluggableInterface,
    TagsAwareInterface,
    TimestampableInterface
{
    use BlameableTrait;
    use IdentifiableTrait;
    use NameableTrait;
    use PicturesAwareTrait;
    use PropertiesAwareTrait;
    use SluggableTrait;
    use TagsAwareTrait;
    use TimestampableTrait;

    #[Assert\NotNull]
    #[ORM\ManyToOne(targetEntity: AircraftType::class, inversedBy: 'aircraftModels')]
    #[ORM\JoinColumn(name: 'aircraft_type', referencedColumnName: 'id', onDelete: 'SET NULL')]
    protected ?AircraftType $aircraftType = null;

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
        $this->pictures = new ArrayCollection();
        $this->propertyValues = new ArrayCollection();
        $this->tags = new ArrayCollection();
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
