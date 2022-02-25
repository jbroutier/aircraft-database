<?php

declare(strict_types=1);

namespace App\Entity\Interface;

interface ContentAwareInterface
{
    public function getContent(): ?string;

    public function setContent(?string $content): self;
}
