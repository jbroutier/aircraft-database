<?php

declare(strict_types=1);

namespace App\Entity\Traits;

use App\Entity\Logo;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

trait LogoAwareTrait
{
    #[Assert\Valid]
    #[ORM\OneToOne(targetEntity: Logo::class, cascade: ['persist'], orphanRemoval: true)]
    #[ORM\JoinColumn(name: 'logo', referencedColumnName: 'id', unique: true, onDelete: 'SET NULL')]
    protected ?Logo $logo = null;

    public function getLogo(): ?Logo
    {
        return $this->logo;
    }

    public function setLogo(?Logo $logo): self
    {
        $this->logo = $logo;
        return $this;
    }
}
