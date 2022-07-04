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
        self::assertNull((new ContentAwareEntity())->getContent());
    }

    /**
     * @testdox Method setContent() sets the content.
     */
    public function testSetContent(): void
    {
        $entity = (new ContentAwareEntity())
            ->setContent('Supermarine Spitfire');

        self::assertEquals('Supermarine Spitfire', $entity->getContent());
    }
}
