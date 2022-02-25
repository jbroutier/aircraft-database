<?php

declare(strict_types=1);

namespace Tests\Functional\Controller\Admin;

use App\Entity\Logo;
use App\Entity\User;
use Tests\Functional\FixturesAwareTestCase;

final class LogoControllerTest extends FixturesAwareTestCase
{
    /**
     * @testdox Accessing "/admin/logos/{id}/delete" deletes the logo.
     * @noinspection SpellCheckingInspection
     */
    public function testDelete(): void
    {
        $client = self::createClient();
        $client->loginUser($this->findEntityBy(User::class, ['username' => 'admin']));
        $logo = $this->findEntityBy(Logo::class, ['originalName' => 'optio-excepturi-ut-quis-dolorum.svg']);
        $client->request('GET', '/admin/logos/' . $logo->getId() . '/delete');

        self::assertResponseStatusCodeSame(200);
    }

    /**
     * @testdox Accessing "/admin/logos/{id}/delete" with an invalid ID returns an HTTP 404 response.
     */
    public function testDeleteWithInvalidId(): void
    {
        $client = self::createClient();
        $client->loginUser($this->findEntityBy(User::class, ['username' => 'admin']));
        $client->request('GET', '/admin/logos/42cfbfd1-e8f2-44d0-83d8-d66775e6d516/delete');

        self::assertResponseStatusCodeSame(404);
    }
}
