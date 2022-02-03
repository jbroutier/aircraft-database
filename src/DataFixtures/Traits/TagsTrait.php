<?php

declare(strict_types=1);

namespace App\DataFixtures\Traits;

use App\Entity\Interface\TagsAwareInterface;
use App\Entity\Tag;
use Faker\Generator;

trait TagsTrait
{
    /**
     * @param array<Tag> $tags
     */
    protected function addTags(Generator $generator, TagsAwareInterface $entity, array $tags): void
    {
        if ($generator->boolean(5)) {
            for ($i = 0; $i < $generator->numberBetween(0, 2); $i++) {
                $entity->addTag($generator->randomElement($tags));
            }
        }
    }
}
