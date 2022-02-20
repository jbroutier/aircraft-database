<?php

declare(strict_types=1);

namespace Tests\Unit\Entity;

use App\Entity\Logo;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\File\File;

final class LogoTest extends TestCase
{
    /**
     * @testdox Method getFile() returns null by default.
     */
    public function testGetFile(): void
    {
        $logo = new Logo();

        self::assertNull($logo->getFile());
    }

    /**
     * @testdox Method setFile() sets the file.
     */
    public function testSetFile(): void
    {
        $file = \Mockery::mock(File::class);

        $logo = new Logo();
        $logo->setFile($file);

        self::assertEquals($file, $logo->getFile());
    }

    /**
     * @testdox Method getFileName() returns null by default.
     */
    public function testGetFileName(): void
    {
        $logo = new Logo();

        self::assertNull($logo->getFileName());
    }

    /**
     * @testdox Method setFileName() sets the file name.
     */
    public function testSetFileName(): void
    {
        $logo = new Logo();
        $logo->setFileName('9f58de6c-3e03-447b-9456-9e4afb974c46.svg');

        self::assertEquals('9f58de6c-3e03-447b-9456-9e4afb974c46.svg', $logo->getFileName());
    }

    /**
     * @testdox Method getMimeType() returns null by default.
     */
    public function testGetMimeType(): void
    {
        $logo = new Logo();

        self::assertNull($logo->getMimeType());
    }

    /**
     * @testdox Method setMimeType() sets the MIME type.
     */
    public function testSetMimeType(): void
    {
        $logo = new Logo();
        $logo->setMimeType('image/svg+xml');

        self::assertEquals('image/svg+xml', $logo->getMimeType());
    }

    /**
     * @testdox Method getOriginalName() returns null by default.
     */
    public function testGetOriginalName(): void
    {
        $logo = new Logo();

        self::assertNull($logo->getOriginalName());
    }

    /**
     * @testdox Method setOriginalName() sets the original name.
     */
    public function testSetOriginalName(): void
    {
        $logo = new Logo();
        $logo->setOriginalName('mcdonnell-douglas.svg');

        self::assertEquals('mcdonnell-douglas.svg', $logo->getOriginalName());
    }

    /**
     * @testdox Method getSize() returns null by default.
     */
    public function testGetSize(): void
    {
        $logo = new Logo();

        self::assertNull($logo->getSize());
    }

    /**
     * @testdox Method setSize() sets the size.
     */
    public function testSetSize(): void
    {
        $logo = new Logo();
        $logo->setSize(48051736);

        self::assertEquals(48051736, $logo->getSize());
    }

    /**
     * @testdox Method __toString() returns the file name.
     */
    public function testToString(): void
    {
        $logo = new Logo();
        $logo->setFileName('5d7cadd1-7f35-4d8b-85a6-1d889f8d37ad.svg');

        self::assertEquals('5d7cadd1-7f35-4d8b-85a6-1d889f8d37ad.svg', (string)$logo);
    }
}
