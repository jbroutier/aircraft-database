<?php

declare(strict_types=1);

namespace App\Service;

use Symfony\Component\Uid\Uuid;
use Vich\UploaderBundle\Mapping\PropertyMapping;
use Vich\UploaderBundle\Naming\NamerInterface;

class UuidNamer implements NamerInterface
{
    public function name($object, PropertyMapping $mapping): string
    {
        if (is_null($file = $mapping->getFile($object))) {
            throw new \RuntimeException('Uploaded file is null.');
        }

        return sprintf('%s.%s', Uuid::v4()->toRfc4122(), $file->guessExtension());
    }
}
