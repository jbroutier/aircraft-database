<?php

declare(strict_types=1);

namespace Tests\Functional\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class ContactControllerTest extends WebTestCase
{
    /**
     * @testdox Accessing "/contact" returns an HTTP 200 response.
     */
    public function testContact(): void
    {
        $client = self::createClient();
        $client->request('GET', '/contact');

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('h1', 'Contact');
    }

    /**
     * @testdox Submitting "/contact" sends the message.
     */
    public function testContactSubmit(): void
    {
        $client = self::createClient();
        $client->request('GET', '/contact');
        $client->submitForm('Send my message', [
            'contact[name]' => 'John doe',
            'contact[address]' => 'john.doe@aircraft-database.com',
            'contact[subject]' => 'Lorem ipsum dolor sit amet.',
            'contact[message]' => 'Vestibulum felis orci, fringilla a sodales quis, consequat non ante.',
            'contact[consent]' => true,
        ]);

        self::assertResponseStatusCodeSame(200);
        self::assertSelectorTextContains('div', 'Message sent');
    }
}
