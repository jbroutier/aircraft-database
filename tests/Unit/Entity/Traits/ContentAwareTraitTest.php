<?php

declare(strict_types=1);

namespace Tests\Unit\Entity\Traits;

use App\Entity\Interface\ContentAwareInterface;
use App\Entity\Traits\ContentAwareTrait;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PHPUnit\Framework\TestCase;

final class ContentAwareEntity implements ContentAwareInterface
{
    use ContentAwareTrait;
}

final class ContentAwareTraitTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    /**
     * @testdox Method getContent() returns null by default.
     */
    public function testGetContent(): void
    {
        $entity = new ContentAwareEntity();

        self::assertNull($entity->getContent());
    }

    /**
     * @testdox Method setContent() sets the content.
     */
    public function testSetContent(): void
    {
        $entity = new ContentAwareEntity();
        $entity->setContent('Sint ea dolorem quia consequuntur accusamus.');

        self::assertEquals('Sint ea dolorem quia consequuntur accusamus.', $entity->getContent());
    }
}
