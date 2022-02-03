<?php

declare(strict_types=1);

namespace App\Twig;

use Composer\Spdx\SpdxLicenses;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class LicenseExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            new TwigFilter('license_name', [$this, 'licenseName']),
            new TwigFilter('license_url', [$this, 'licenseUrl']),
        ];
    }

    public function licenseName(string $identifier): ?string
    {
        $licenses = new SpdxLicenses();

        if (is_null($license = $licenses->getLicenseByIdentifier($identifier))) {
            return null;
        }

        return $license[0];
    }

    public function licenseUrl(string $identifier): ?string
    {
        $licenses = new SpdxLicenses();

        if (is_null($license = $licenses->getLicenseByIdentifier($identifier))) {
            return null;
        }

        return $license[2];
    }
}
