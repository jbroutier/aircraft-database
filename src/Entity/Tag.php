<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Interface\BlameableInterface;
use App\Entity\Interface\DescriptionAwareInterface;
use App\Entity\Interface\IdentifiableInterface;
use App\Entity\Interface\NameableInterface;
use App\Entity\Interface\SluggableInterface;
use App\Entity\Interface\TimestampableInterface;
use App\Entity\Traits\BlameableTrait;
use App\Entity\Traits\DescriptionAwareTrait;
use App\Entity\Traits\IdentifiableTrait;
use App\Entity\Traits\NameableTrait;
use App\Entity\Traits\SluggableTrait;
use App\Entity\Traits\TimestampableTrait;
use App\Repository\TagRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[UniqueEntity(['slug'])]
#[ORM\Entity(repositoryClass: TagRepository::class)]
class Tag implements BlameableInterface, DescriptionAwareInterface, IdentifiableInterface, NameableInterface,
                     SluggableInterface, TimestampableInterface
{
    use BlameableTrait;
    use DescriptionAwareTrait;
    use IdentifiableTrait;
    use NameableTrait;
    use SluggableTrait;
    use TimestampableTrait;

    #[Assert\NotBlank]
    #[Assert\CssColor(formats: Assert\CssColor::HEX_LONG)]
    #[ORM\Column(name: 'color', type: 'string', length: 7)]
    protected ?string $color = null;

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(?string $color): Tag
    {
        $this->color = $color;
        return $this;
    }
}
