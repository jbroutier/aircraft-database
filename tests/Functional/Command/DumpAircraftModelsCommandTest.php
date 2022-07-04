<?php

declare(strict_types=1);

namespace Tests\Functional\Command;

use App\Factory\AircraftModelFactory;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Tester\CommandTester;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

class DumpAircraftModelsCommandTest extends KernelTestCase
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
     * @testdox Running command "dump:aircraft-models" dumps the aircraft models.
     */
    public function testExecute(): void
    {
        AircraftModelFactory::createOne();

        $command = $this->application->find('dump:aircraft-models');
        $commandTester = new CommandTester($command);
        $commandTester->execute([]);

        self::assertEquals(Command::SUCCESS, $commandTester->getStatusCode());
        self::assertFileExists('dump/aircraft-models.csv');

        unlink('dump/aircraft-models.csv');
    }
}
