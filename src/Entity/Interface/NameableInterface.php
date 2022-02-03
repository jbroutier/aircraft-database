<?php

declare(strict_types=1);

namespace App\Entity\Interface;

interface NameableInterface
{
    public function getName(): ?string;

    public function setName(?string $name): self;
}
