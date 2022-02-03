<?php

declare(strict_types=1);

namespace App\Entity\Interface;

interface TimestampableInterface
{
    public function getCreatedAt(): ?\DateTimeInterface;

    public function setCreatedAt(?\DateTimeInterface $createdAt): self;

    public function getUpdatedAt(): ?\DateTimeInterface;

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self;
}
