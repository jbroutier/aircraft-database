<?php

declare(strict_types=1);

namespace Tests\Functional\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class StaticControllerTest extends WebTestCase
{
    /**
     * @testdox Accessing "/cookie-policy" returns an HTTP 200 response.
     */
    public function testCookiePolicy(): void
    {
        $client = self::createClient();
        $client->request('GET', '/cookie-policy');

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('h1', 'Cookie policy');
    }

    /**
     * @testdox Accessing "/legal-notice" returns an HTTP 200 response.
     */
    public function testLegalNotice(): void
    {
        $client = self::createClient();
        $client->request('GET', '/legal-notice');

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('h1', 'Legal notice');
    }

    /**
     * @testdox Accessing "/privacy-policy" returns an HTTP 200 response.
     */
    public function testPrivacyPolicy(): void
    {
        $client = self::createClient();
        $client->request('GET', '/privacy-policy');

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('h1', 'Privacy policy');
    }
}
