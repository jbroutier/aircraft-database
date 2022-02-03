<?php

declare(strict_types=1);

namespace App\Entity\Interface;

interface DescriptionAwareInterface
{
    public function getDescription(): ?string;

    public function setDescription(?string $description): self;
}
