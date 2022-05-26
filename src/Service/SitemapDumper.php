<?php

declare(strict_types=1);

namespace App\Service;

use Presta\SitemapBundle\Service\DumperInterface;
use Presta\SitemapBundle\Sitemap\Url\Url;
use Symfony\Component\HttpFoundation\UrlHelper;

class SitemapDumper implements DumperInterface
{
    public function __construct(
        protected readonly DumperInterface $decorated,
        protected readonly UrlHelper $urlHelper,
        protected readonly string $directory
    ) {
    }

    public function addUrl(Url $url, string $section): void
    {
        $this->decorated->addUrl($url, $section);
    }

    public function dump(string $targetDir, string $host, string $section = null, array $options = []): array|bool
    {
        $host = $this->urlHelper->getAbsoluteUrl($this->directory);
        return $this->decorated->dump($targetDir, $host, $section, $options);
    }
}
