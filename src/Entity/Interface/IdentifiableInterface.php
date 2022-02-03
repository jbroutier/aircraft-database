<?php

declare(strict_types=1);

namespace App\Entity\Interface;

use Symfony\Component\Uid\Uuid;

interface IdentifiableInterface
{
    public function getId(): Uuid;
}
