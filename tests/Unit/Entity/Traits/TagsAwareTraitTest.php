<?php

declare(strict_types=1);

namespace Tests\Unit\Entity\Traits;

use App\Entity\Interface\TagsAwareInterface;
use App\Entity\Tag;
use App\Entity\Traits\TagsAwareTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PHPUnit\Framework\TestCase;

final class TagsAwareEntity implements TagsAwareInterface
{
    use TagsAwareTrait;

    public function __construct()
    {
        $this->tags = new ArrayCollection();
    }
}

final class TagsAwareTraitTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    /**
     * @testdox Method addTag() adds a tag.
     */
    public function testAddTag(): void
    {
        $tag = \Mockery::mock(Tag::class);

        $entity = (new TagsAwareEntity())
            ->addTag($tag);

        self::assertCount(1, $entity->getTags());
        self::assertContains($tag, $entity->getTags());
    }

    /**
     * @testdox Method removeTag() removes a tag.
     */
    public function testRemoveTag(): void
    {
        $tag = \Mockery::mock(Tag::class);

        $entity = new TagsAwareEntity();
        $entity
            ->setTags([$tag])
            ->removeTag($tag);

        self::assertEmpty($entity->getTags());
    }

    /**
     * @testdox Method setTags() sets the tags.
     */
    public function testSetTags(): void
    {
        $tag = \Mockery::mock(Tag::class);

        $entity = (new TagsAwareEntity())
            ->setTags([$tag]);

        self::assertCount(1, $entity->getTags());
        self::assertContains($tag, $entity->getTags());
    }
}
