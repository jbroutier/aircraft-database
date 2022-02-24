<?php

declare(strict_types=1);

namespace App\DataFixtures\Traits;

use App\Entity\Interface\PicturesAwareInterface;
use App\Entity\Picture;
use Composer\Spdx\SpdxLicenses;
use Faker\Generator;
use Symfony\Component\HttpFoundation\File\UploadedFile;

trait PicturesTrait
{
    /**
     * @param array<string> $pictures
     */
    protected function addPictures(Generator $generator, PicturesAwareInterface $entity, array $pictures): void
    {
        $licenses = new SpdxLicenses();
        $licenses = array_keys($licenses->getLicenses());

        for ($i = 0; $i < $generator->numberBetween(1, 5); $i++) {
            if (($file = tempnam(sys_get_temp_dir(), 'picture')) === false) {
                throw new \RuntimeException('Could not create temporary file');
            }

            copy($pictures[$i], $file);

            $picture = new Picture();
            $picture
                ->setAuthorName($generator->name())
                ->setAuthorProfile($generator->optional()->url())
                ->setFile(new UploadedFile($file, $generator->slug() . '.jpg', test: true))
                ->setLicense($generator->randomElement($licenses))
                ->setSource($generator->url());

            $entity->addPicture($picture);
        }
    }
}
