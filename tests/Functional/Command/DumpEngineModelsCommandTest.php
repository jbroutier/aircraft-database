<?php

declare(strict_types=1);

namespace Tests\Functional\Command;

use App\Factory\EngineModelFactory;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Tester\CommandTester;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

class DumpEngineModelsCommandTest extends KernelTestCase
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
     * @testdox Running command "dump:engine-models" dumps the engine models.
     */
    public function testExecute(): void
    {
        EngineModelFactory::createOne();

        $command = $this->application->find('dump:engine-models');
        $commandTester = new CommandTester($command);
        $commandTester->execute([]);

        self::assertEquals(Command::SUCCESS, $commandTester->getStatusCode());
        self::assertFileExists('dump/engine-models.csv');

        unlink('dump/engine-models.csv');
    }
}
