<?php

declare(strict_types=1);

namespace App\Entity\Traits;

use App\Entity\Tag;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

trait TagsAwareTrait
{
    /**
     * @var Collection<int, Tag>
     */
    #[Assert\Valid]
    #[ORM\OrderBy(['name' => 'ASC'])]
    #[ORM\ManyToMany(targetEntity: Tag::class, cascade: ['persist'])]
    #[ORM\JoinTable]
    #[ORM\JoinColumn(name: 'entity', referencedColumnName: 'id', nullable: false, onDelete: 'CASCADE')]
    #[ORM\InverseJoinColumn(name: 'tag', referencedColumnName: 'id', nullable: false, onDelete: 'CASCADE')]
    protected Collection $tags;

    /**
     * @return Collection<int, Tag>
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    public function addTag(Tag $tag): self
    {
        if (!$this->tags->contains($tag)) {
            $this->tags->add($tag);
        }

        return $this;
    }

    public function removeTag(Tag $tag): self
    {
        $this->tags->removeElement($tag);
        return $this;
    }

    /**
     * @param Tag[] $tags
     */
    public function setTags(array $tags): self
    {
        $this->tags = new ArrayCollection($tags);
        return $this;
    }
}
