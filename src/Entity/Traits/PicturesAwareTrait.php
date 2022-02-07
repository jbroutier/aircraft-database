<?php

declare(strict_types=1);

namespace App\Entity\Traits;

use App\Entity\Picture;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

trait PicturesAwareTrait
{
    /**
     * @var Collection<int, Picture>
     */
    #[Assert\Valid]
    #[ORM\ManyToMany(targetEntity: Picture::class, cascade: ['persist'], orphanRemoval: true)]
    #[ORM\JoinTable]
    #[ORM\JoinColumn(name: 'entity', referencedColumnName: 'id', nullable: false, onDelete: 'CASCADE')]
    #[ORM\InverseJoinColumn(name: 'picture', referencedColumnName: 'id', unique: true, nullable: false, onDelete: 'CASCADE')]
    protected Collection $pictures;

    /**
     * @return Collection<int, Picture>
     */
    public function getPictures(): Collection
    {
        return $this->pictures;
    }

    public function addPicture(Picture $picture): self
    {
        if (!$this->pictures->contains($picture)) {
            $this->pictures->add($picture);
        }

        return $this;
    }

    public function removePicture(Picture $picture): self
    {
        $this->pictures->removeElement($picture);
        return $this;
    }
}
