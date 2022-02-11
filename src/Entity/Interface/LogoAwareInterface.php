<?php

declare(strict_types=1);

namespace App\Entity\Interface;

use App\Entity\Logo;

interface LogoAwareInterface
{
    public function getLogo(): ?Logo;

    public function setLogo(?Logo $logo): self;
}
