<?php

declare(strict_types=1);

namespace App\DataFixtures\Traits;

use App\Entity\Interface\LogoAwareInterface;
use App\Entity\Logo;
use Faker\Generator;
use Symfony\Component\HttpFoundation\File\UploadedFile;

trait LogoTrait
{
    protected static string $logo = '<svg xmlns="http://www.w3.org/2000/svg" width="680.764" height="528.354" viewBox="0 0 180.119 139.794"><g transform="translate(-13.59 -66.639)"><path style="opacity:1;fill:#d0d0d0;fill-opacity:1;stroke:none;stroke-width:2.96123242;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1;paint-order:fill markers stroke" d="M13.591 66.639H193.71v139.794H13.591z"/><path style="opacity:.675;fill:#fff;fill-opacity:1;stroke:none;stroke-width:2.98038435;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1;paint-order:fill markers stroke" d="m118.507 133.514-34.249 34.249-15.968-15.968-41.938 41.937h152.374z"/><circle style="opacity:.675;fill:#fff;fill-opacity:1;stroke:none;stroke-width:1.99717033;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1;paint-order:fill markers stroke" cx="58.217" cy="108.555" r="11.773"/><path style="opacity:1;fill:none;fill-opacity:1;stroke:none;stroke-width:2.96123242;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1;paint-order:fill markers stroke" d="M26.111 77.634h152.614v116.099H26.111z"/></g></svg>';

    protected function setLogo(Generator $generator, LogoAwareInterface $entity): void
    {
        if ($generator->boolean()) {
            if (($file = tempnam(sys_get_temp_dir(), 'logo')) === false) {
                throw new \RuntimeException('Could not create temporary file');
            }

            file_put_contents($file, self::$logo);

            $logo = new Logo();
            $logo->setFile(new UploadedFile($file, $generator->slug() . '.svg', test: true));

            $entity->setLogo($logo);
        }
    }
}
