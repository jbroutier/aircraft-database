<?php

declare(strict_types=1);

namespace App\Entity\Interface;

use App\Entity\Tag;
use Doctrine\Common\Collections\Collection;

interface TagsAwareInterface
{
    /**
     * @return Collection<int, Tag>
     */
    public function getTags(): Collection;

    public function addTag(Tag $tag): self;

    public function removeTag(Tag $tag): self;

    /**
     * @param Tag[] $tags
     */
    public function setTags(array $tags): self;
}
