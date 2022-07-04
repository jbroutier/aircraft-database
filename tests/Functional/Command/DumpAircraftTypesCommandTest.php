<?php

declare(strict_types=1);

namespace Tests\Functional\Command;

use App\Factory\AircraftTypeFactory;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Tester\CommandTester;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

class DumpAircraftTypesCommandTest extends KernelTestCase
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
     * @testdox Running command "dump:aircraft-types" dumps the aircraft types.
     */
    public function testExecute(): void
    {
        AircraftTypeFactory::createOne();

        $command = $this->application->find('dump:aircraft-types');
        $commandTester = new CommandTester($command);
        $commandTester->execute([]);

        self::assertEquals(Command::SUCCESS, $commandTester->getStatusCode());
        self::assertFileExists('dump/aircraft-types.csv');

        unlink('dump/aircraft-types.csv');
    }
}
