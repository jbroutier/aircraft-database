<?php

declare(strict_types=1);

namespace Tests\Functional\Command;

use App\Factory\AircraftModelFactory;
use App\Factory\AircraftTypeFactory;
use App\Factory\EngineModelFactory;
use App\Factory\ManufacturerFactory;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Tester\CommandTester;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

class PrestaSitemapDumpCommandTest extends KernelTestCase
{
    use Factories;
    use ResetDatabase;

    private Application $application;

    public function setUp(): void
    {
        $kernel = self::bootKernel();
        $this->application = new Application($kernel);
    }

    /**
     * @testdox Running command "presta:sitemap:dump" generates the sitemap.
     */
    public function testExecute(): void
    {
        AircraftModelFactory::createOne();
        AircraftTypeFactory::createOne();
        EngineModelFactory::createOne();
        ManufacturerFactory::createOne();

        $command = $this->application->find('presta:sitemap:dump');
        $commandTester = new CommandTester($command);
        $commandTester->execute([]);

        self::assertEquals(Command::SUCCESS, $commandTester->getStatusCode());
        self::assertFileExists('public/sitemap/sitemap.xml');
        self::assertFileExists('public/sitemap/sitemap.aircraft_models.xml');
        self::assertFileExists('public/sitemap/sitemap.aircraft_types.xml');
        self::assertFileExists('public/sitemap/sitemap.engine_models.xml');
        self::assertFileExists('public/sitemap/sitemap.manufacturers.xml');

        unlink('public/sitemap/sitemap.xml');
        unlink('public/sitemap/sitemap.aircraft_models.xml');
        unlink('public/sitemap/sitemap.aircraft_types.xml');
        unlink('public/sitemap/sitemap.engine_models.xml');
        unlink('public/sitemap/sitemap.manufacturers.xml');
    }
}
