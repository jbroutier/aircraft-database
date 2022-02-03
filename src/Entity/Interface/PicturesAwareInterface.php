<?php

declare(strict_types=1);

namespace App\Entity\Interface;

use App\Entity\Picture;
use Doctrine\Common\Collections\Collection;

interface PicturesAwareInterface
{
    /**
     * @return Collection<int, Picture>
     */
    public function getPictures(): Collection;

    public function addPicture(Picture $picture): self;

    public function removePicture(Picture $picture): self;
}
