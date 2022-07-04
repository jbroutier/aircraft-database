<?php

declare(strict_types=1);

namespace Tests\Unit\Entity\Traits;

use App\Entity\Interface\PicturesAwareInterface;
use App\Entity\Picture;
use App\Entity\Traits\PicturesAwareTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PHPUnit\Framework\TestCase;

final class PicturesAwareEntity implements PicturesAwareInterface
{
    use PicturesAwareTrait;

    public function __construct()
    {
        $this->pictures = new ArrayCollection();
    }
}

final class PicturesAwareTraitTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    /**
     * @testdox Method addPicture() adds a picture.
     */
    public function testAddPicture(): void
    {
        $picture = \Mockery::mock(Picture::class);

        $entity = (new PicturesAwareEntity())
            ->addPicture($picture);

        self::assertCount(1, $entity->getPictures());
        self::assertContains($picture, $entity->getPictures());
    }

    /**
     * @testdox Method removePicture() removes a picture.
     */
    public function testRemovePicture(): void
    {
        $picture = \Mockery::mock(Picture::class);

        $entity = (new PicturesAwareEntity())
            ->setPictures([$picture])
            ->removePicture($picture);

        self::assertEmpty($entity->getPictures());
    }

    /**
     * @testdox Method setPictures() sets the pictures.
     */
    public function testSetPictures(): void
    {
        $picture = \Mockery::mock(Picture::class);

        $entity = (new PicturesAwareEntity())
            ->setPictures([$picture]);

        self::assertCount(1, $entity->getPictures());
        self::assertContains($picture, $entity->getPictures());
    }
}
