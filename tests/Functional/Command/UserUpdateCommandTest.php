<?php

declare(strict_types=1);

namespace Tests\Functional\Command;

use App\Factory\UserFactory;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Tester\CommandTester;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

class UserUpdateCommandTest extends KernelTestCase
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
     * @testdox Running command "user:update" updates the user.
     */
    public function testExecute(): void
    {
        UserFactory::createOne(['email' => 'jeremie.broutier@posteo.net']);

        $command = $this->application->find('user:update');
        $commandTester = new CommandTester($command);
        $commandTester->setInputs(['#Az67dDke$', 'Jérémie', 'Broutier', 'yes']);
        $commandTester->execute(['email' => 'jeremie.broutier@posteo.net'], ['interactive' => true]);

        self::assertEquals(Command::SUCCESS, $commandTester->getStatusCode());
    }

    /**
     * @testdox Running command "user:update" with an invalid email address returns an error.
     */
    public function testExecuteWithInvalidEmail(): void
    {
        $command = $this->application->find('user:update');
        $commandTester = new CommandTester($command);
        $commandTester->execute(['email' => 'invalid-email']);

        self::assertEquals(Command::FAILURE, $commandTester->getStatusCode());
    }
}
