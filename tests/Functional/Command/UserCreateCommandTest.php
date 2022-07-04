<?php

declare(strict_types=1);

namespace Tests\Functional\Command;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Tester\CommandTester;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

class UserCreateCommandTest extends KernelTestCase
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
     * @testdox Running command "user:create" creates the user.
     */
    public function testExecute(): void
    {
        $command = $this->application->find('user:create');
        $commandTester = new CommandTester($command);
        $commandTester->setInputs(['jeremie.broutier@posteo.net', '#Az67dDke$', 'Jérémie', 'Broutier', 'yes']);
        $commandTester->execute([], ['interactive' => true]);

        self::assertEquals(Command::SUCCESS, $commandTester->getStatusCode());
    }
}
