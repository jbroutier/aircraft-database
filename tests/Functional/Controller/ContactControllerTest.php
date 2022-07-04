<?php

declare(strict_types=1);

namespace Tests\Functional\Controller;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class ContactControllerTest extends WebTestCase
{
    private KernelBrowser $client;

    public function setUp(): void
    {
        $this->client = self::createClient();
    }

    /**
     * @testdox Accessing "/contact" returns an HTTP 200 response.
     */
    public function testContact(): void
    {
        $this->client->request('GET', '/contact');

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('h1', 'Contact');
    }

    /**
     * @testdox Submitting "/contact" sends the message.
     */
    public function testSubmitContact(): void
    {
        $this->client->request('GET', '/contact');
        $this->client->submitForm('Send message', [
            'contact[address]' => 'jeremie.broutier@posteo.net',
            'contact[consenting]' => '1',
            'contact[message]' => 'Lorem ipsum dolor sit amet',
            'contact[name]' => 'Jérémie Broutier',
            'contact[subject]' => 'Lorem ipsum dolor sit amet',
        ]);

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('div', 'Your message has been sent.');
    }
}
