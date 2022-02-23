<?php

declare(strict_types=1);

namespace Tests\Functional\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class SearchControllerTest extends WebTestCase
{
    /**
     * @testdox Accessing "/search" returns an HTTP 200 response.
     */
    public function testSearch(): void
    {
        $client = self::createClient();
        $client->request('GET', '/search', ['query' => 'test']);

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('h3', 'Search results for «test»');
    }

    /**
     * @testdox Accessing "/search" without a query redirects to the index.
     */
    public function testSearchWithoutQuery(): void
    {
        $client = self::createClient();
        $client->request('GET', '/search');

        self::assertResponseRedirects('/', 302);
    }
}
