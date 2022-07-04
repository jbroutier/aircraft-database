<?php

declare(strict_types=1);

namespace Tests\Unit\Entity;

use App\Entity\Picture;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\File\File;

final class PictureTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    /**
     * @testdox Method getAuthorName() returns null by default.
     */
    public function testGetAuthorName(): void
    {
        self::assertNull((new Picture())->getAuthorName());
    }

    /**
     * @testdox Method setAuthorName() sets the author name.
     */
    public function testSetAuthorName(): void
    {
        $picture = (new Picture())
            ->setAuthorName('Gene Erickson');

        self::assertEquals('Gene Erickson', $picture->getAuthorName());
    }

    /**
     * @testdox Method getAuthorProfile() returns null by default.
     */
    public function testGetAuthorProfile(): void
    {
        self::assertNull((new Picture())->getAuthorProfile());
    }

    /**
     * @testdox Method setAuthorProfile() sets the author profile.
     */
    public function testSetAuthorProfile(): void
    {
        $picture = (new Picture())
            ->setAuthorProfile('https://orn.com/excepturi-sit-vero-commodi');

        self::assertEquals('https://orn.com/excepturi-sit-vero-commodi', $picture->getAuthorProfile());
    }

    /**
     * @testdox Method getDimensions() returns null by default.
     */
    public function testGetDimensions(): void
    {
        self::assertNull((new Picture())->getDimensions());
    }

    /**
     * @testdox Method setDimensions() sets the dimensions.
     */
    public function testSetDimensions(): void
    {
        $picture = (new Picture())
            ->setDimensions([1920, 1080]);

        self::assertEquals([1920, 1080], $picture->getDimensions());
    }

    /**
     * @testdox Method getFile() returns null by default.
     */
    public function testGetFile(): void
    {
        self::assertNull((new Picture())->getFile());
    }

    /**
     * @testdox Method setFile() sets the file.
     */
    public function testSetFile(): void
    {
        $file = \Mockery::mock(File::class);

        $picture = (new Picture())
            ->setFile($file);

        self::assertEquals($file, $picture->getFile());
    }

    /**
     * @testdox Method getFileName() returns null by default.
     */
    public function testGetFileName(): void
    {
        self::assertNull((new Picture())->getFileName());
    }

    /**
     * @testdox Method setFileName() sets the file name.
     */
    public function testSetFileName(): void
    {
        $picture = (new Picture())
            ->setFileName('254d5085-83ef-4197-aa56-ab038bc2f43c.jpg');

        self::assertEquals('254d5085-83ef-4197-aa56-ab038bc2f43c.jpg', $picture->getFileName());
    }

    /**
     * @testdox Method getLicense() returns null by default.
     */
    public function testGetLicense(): void
    {
        self::assertNull((new Picture())->getLicense());
    }

    /**
     * @testdox Method setLicense() sets the license.
     */
    public function testSetLicense(): void
    {
        $picture = (new Picture())
            ->setLicense('CC-BY-SA-2.0');

        self::assertEquals('CC-BY-SA-2.0', $picture->getLicense());
    }

    /**
     * @testdox Method getMimeType() returns null by default.
     */
    public function testGetMimeType(): void
    {
        self::assertNull((new Picture())->getMimeType());
    }

    /**
     * @testdox Method setMimeType() sets the MIME type.
     */
    public function testSetMimeType(): void
    {
        $picture = (new Picture())
            ->setMimeType('image/jpeg');

        self::assertEquals('image/jpeg', $picture->getMimeType());
    }

    /**
     * @testdox Method getOriginalName() returns null by default.
     */
    public function testGetOriginalName(): void
    {
        self::assertNull((new Picture())->getOriginalName());
    }

    /**
     * @testdox Method setOriginalName() sets the original name.
     */
    public function testSetOriginalName(): void
    {
        $picture = (new Picture())
            ->setOriginalName('c130j-super-hercules.jpg');

        self::assertEquals('c130j-super-hercules.jpg', $picture->getOriginalName());
    }

    /**
     * @testdox Method getSize() returns null by default.
     */
    public function testGetSize(): void
    {
        self::assertNull((new Picture())->getSize());
    }

    /**
     * @testdox Method setSize() sets the size.
     */
    public function testSetSize(): void
    {
        $picture = (new Picture())
            ->setSize(784514);

        self::assertEquals(784514, $picture->getSize());
    }

    /**
     * @testdox Method getSource() returns null by default.
     */
    public function testGetSource(): void
    {
        self::assertNull((new Picture())->getSource());
    }

    /**
     * @testdox Method setSource() sets the source.
     */
    public function testSetSource(): void
    {
        $picture = (new Picture())
            ->setSource('https://www.aufderhar.org/doloribus-ipsam-omnis');

        self::assertEquals('https://www.aufderhar.org/doloribus-ipsam-omnis', $picture->getSource());
    }

    /**
     * @testdox Method __toString() returns the file name.
     */
    public function testToString(): void
    {
        $picture = (new Picture())
            ->setFileName('31dce0d1-023b-4e19-9cd4-2ef2cab9a344.jpg');

        self::assertEquals('31dce0d1-023b-4e19-9cd4-2ef2cab9a344.jpg', $picture->__toString());
    }
}
