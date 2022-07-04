<?php

declare(strict_types=1);

namespace Tests\Unit\Entity;

use App\Entity\Logo;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\File\File;

final class LogoTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    /**
     * @testdox Method getFile() returns null by default.
     */
    public function testGetFile(): void
    {
        self::assertNull((new Logo())->getFile());
    }

    /**
     * @testdox Method setFile() sets the file.
     */
    public function testSetFile(): void
    {
        $file = \Mockery::mock(File::class);

        $logo = (new Logo())
            ->setFile($file);

        self::assertEquals($file, $logo->getFile());
    }

    /**
     * @testdox Method getFileName() returns null by default.
     */
    public function testGetFileName(): void
    {
        self::assertNull((new Logo())->getFileName());
    }

    /**
     * @testdox Method setFileName() sets the file name.
     */
    public function testSetFileName(): void
    {
        $logo = (new Logo())
            ->setFileName('9f58de6c-3e03-447b-9456-9e4afb974c46.svg');

        self::assertEquals('9f58de6c-3e03-447b-9456-9e4afb974c46.svg', $logo->getFileName());
    }

    /**
     * @testdox Method getMimeType() returns null by default.
     */
    public function testGetMimeType(): void
    {
        self::assertNull((new Logo())->getMimeType());
    }

    /**
     * @testdox Method setMimeType() sets the MIME type.
     */
    public function testSetMimeType(): void
    {
        $logo = (new Logo())
            ->setMimeType('image/svg+xml');

        self::assertEquals('image/svg+xml', $logo->getMimeType());
    }

    /**
     * @testdox Method getOriginalName() returns null by default.
     */
    public function testGetOriginalName(): void
    {
        self::assertNull((new Logo())->getOriginalName());
    }

    /**
     * @testdox Method setOriginalName() sets the original name.
     */
    public function testSetOriginalName(): void
    {
        $logo = (new Logo())
            ->setOriginalName('mcdonnell-douglas.svg');

        self::assertEquals('mcdonnell-douglas.svg', $logo->getOriginalName());
    }

    /**
     * @testdox Method getSize() returns null by default.
     */
    public function testGetSize(): void
    {
        self::assertNull((new Logo())->getSize());
    }

    /**
     * @testdox Method setSize() sets the size.
     */
    public function testSetSize(): void
    {
        $logo = (new Logo())
            ->setSize(149473);

        self::assertEquals(149473, $logo->getSize());
    }

    /**
     * @testdox Method __toString() returns the file name.
     */
    public function testToString(): void
    {
        $logo = (new Logo())
            ->setFileName('5d7cadd1-7f35-4d8b-85a6-1d889f8d37ad.svg');

        self::assertEquals('5d7cadd1-7f35-4d8b-85a6-1d889f8d37ad.svg', $logo->__toString());
    }
}
