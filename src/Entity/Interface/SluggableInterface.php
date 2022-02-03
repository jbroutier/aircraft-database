<?php

declare(strict_types=1);

namespace App\Entity\Interface;

interface SluggableInterface
{
    public function getSlug(): ?string;

    public function setSlug(?string $slug): self;
}
