<?php

declare(strict_types=1);

namespace App\Entity\Interface;

use Symfony\Component\Security\Core\User\UserInterface;

interface BlameableInterface
{
    public function getCreatedBy(): ?UserInterface;

    public function setCreatedBy(?UserInterface $user): self;

    public function getUpdatedBy(): ?UserInterface;

    public function setUpdatedBy(?UserInterface $user): self;
}
