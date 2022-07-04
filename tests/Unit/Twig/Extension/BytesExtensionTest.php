<?php

declare(strict_types=1);

namespace Tests\Unit\Twig\Extension;

use App\Twig\Extension\BytesExtension;
use PHPUnit\Framework\TestCase;

final class BytesExtensionTest extends TestCase
{
    /**
     * @testdox Method formatBytes() formats the size as a human-readable value.
     */
    public function testFormatBytes(): void
    {
        $extension = new BytesExtension();

        self::assertEquals('1.00 Kb', $extension->formatBytes(pow(1024, 1)));
        self::assertEquals('1.00 Mb', $extension->formatBytes(pow(1024, 2)));
        self::assertEquals('1.00 Gb', $extension->formatBytes(pow(1024, 3)));
        self::assertEquals('1.00 Tb', $extension->formatBytes(pow(1024, 4)));
        self::assertEquals('1.00 Pb', $extension->formatBytes(pow(1024, 5)));
        self::assertEquals('1.00 Eb', $extension->formatBytes(pow(1024, 6)));
        self::assertEquals('1.00 Zb', $extension->formatBytes(pow(1024, 7)));
        self::assertEquals('1.00 Yb', $extension->formatBytes(pow(1024, 8)));
    }
}
