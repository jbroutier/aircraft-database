<?php

declare(strict_types=1);

namespace Tests\Unit\Entity\Traits;

use App\Entity\Interface\LogoAwareInterface;
use App\Entity\Logo;
use App\Entity\Traits\LogoAwareTrait;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PHPUnit\Framework\TestCase;

final class LogoAwareEntity implements LogoAwareInterface
{
    use LogoAwareTrait;
}

final class LogoAwareTraitTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    /**
     * @testdox Method getLogo() returns null by default.
     */
    public function testGetLogo(): void
    {
        $entity = new LogoAwareEntity();

        self::assertNull($entity->getLogo());
    }

    /**
     * @testdox Method setLogo() sets the logo.
     */
    public function testSetLogo(): void
    {
        $logo = \Mockery::mock(Logo::class);

        $entity = new LogoAwareEntity();
        $entity->setLogo($logo);

        self::assertEquals($logo, $entity->getLogo());
    }
}
