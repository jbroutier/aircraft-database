<?php

declare(strict_types=1);

namespace Tests\Unit\Twig\Extension;

use App\Twig\Extension\LicenseExtension;
use PHPUnit\Framework\TestCase;

final class LicenseExtensionTest extends TestCase
{
    /**
     * @testdox Method licenseName() returns the license name.
     */
    public function testLicenseName(): void
    {
        $extension = new LicenseExtension();

        self::assertEquals('Creative Commons Attribution 2.0 Generic', $extension->licenseName('CC-BY-2.0'));
    }

    /**
     * @testdox Method licenseName() returns null when an invalid identifier is provided.
     */
    public function testLicenseNameWithInvalidIdentifier(): void
    {
        $extension = new LicenseExtension();

        self::assertNull($extension->licenseName('ZZZ'));
    }

    /**
     * @testdox Method licenseUrl() returns the license URL.
     */
    public function testLicenseUrl(): void
    {
        $extension = new LicenseExtension();

        self::assertEquals('https://spdx.org/licenses/MIT.html#licenseText', $extension->licenseUrl('MIT'));
    }

    /**
     * @testdox Method licenseUrl() returns null when an invalid identifier is provided.
     */
    public function testLicenseUrlWithInvalidIdentifier(): void
    {
        $extension = new LicenseExtension();

        self::assertNull($extension->licenseUrl('ZZZ'));
    }
}
