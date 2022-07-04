<?php

declare(strict_types=1);

namespace Tests\Functional\Controller;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class StaticControllerTest extends WebTestCase
{
    private KernelBrowser $client;

    public function setUp(): void
    {
        $this->client = self::createClient();
    }

    /**
     * @testdox Accessing "/cookie-policy" returns an HTTP 200 response.
     */
    public function testCookiePolicy(): void
    {
        $this->client->request('GET', '/cookie-policy');

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('h1', 'Cookie policy');
    }

    /**
     * @testdox Accessing "/legal-notice" returns an HTTP 200 response.
     */
    public function testLegalNotice(): void
    {
        $this->client->request('GET', '/legal-notice');

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('h1', 'Legal notice');
    }

    /**
     * @testdox Accessing "/privacy-policy" returns an HTTP 200 response.
     */
    public function testPrivacyPolicy(): void
    {
        $this->client->request('GET', '/privacy-policy');

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('h1', 'Privacy policy');
    }
}
