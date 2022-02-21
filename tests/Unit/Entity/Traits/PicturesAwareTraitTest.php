<?php

declare(strict_types=1);

namespace Tests\Unit\Entity\Traits;

use App\Entity\Interface\PicturesAwareInterface;
use App\Entity\Picture;
use App\Entity\Traits\PicturesAwareTrait;
use Doctrine\Common\Collections\ArrayCollection;
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
    /**
     * @testdox Method addPicture() adds a picture.
     */
    public function testAddPicture(): void
    {
        $picture = \Mockery::mock(Picture::class);

        $entity = new PicturesAwareEntity();
        $entity->addPicture($picture);

        self::assertEquals($picture, $entity->getPictures()->first());
    }

    /**
     * @testdox Method removePicture() removes a picture.
     */
    public function testRemovePicture(): void
    {
        $picture = \Mockery::mock(Picture::class);

        $entity = new PicturesAwareEntity();
        $entity
            ->setPictures([$picture])
            ->removePicture($picture);

        self::assertEmpty($entity->getPictures());
    }

    /**
     * @testdox Method setPictures() sets the pictures.
     */
    public function testSetPictures(): void
    {
        $pictures = [
            \Mockery::mock(Picture::class),
            \Mockery::mock(Picture::class),
        ];

        $entity = new PicturesAwareEntity();
        $entity->setPictures($pictures);

        self::assertEquals($pictures, $entity->getPictures()->toArray());
    }
}