<?php

declare(strict_types=1);

namespace Tests\Unit\Factory;

use App\Entity\EngineModel;
use App\Factory\EngineModelFactory;
use PHPUnit\Framework\TestCase;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\Test\Factories;

final class EngineModelFactoryTest extends TestCase
{
    use Factories;

    /**
     * @testdox Method createOne() returns an instance of Proxy<EngineModel>.
     */
    public function testCreate(): void
    {
        $engineModel = EngineModelFactory::createOne();

        self::assertInstanceOf(Proxy::class, $engineModel);
    }

    /**
     * @testdox Method createOne() generates the slug from the name by default.
     */
    public function testCreateWithoutSlug(): void
    {
        /** @var Proxy<EngineModel> $engineModel */
        $engineModel = EngineModelFactory::createOne(['name' => 'Ardiden 1H1']);

        self::assertEquals('ardiden-1h1', $engineModel->getSlug());
    }
}
