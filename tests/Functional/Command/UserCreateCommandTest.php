<?php

declare(strict_types=1);

namespace Tests\Functional\Command;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;

final class UserCreateCommandTest extends KernelTestCase
{
    /**
     * @testdox Command executes successfully.
     */
    public function testCreateUser(): void
    {
        $kernel = self::bootKernel();
        $application = new Application($kernel);

        $command = $application->find('user:create');
        $commandTester = new CommandTester($command);
        $commandTester->setInputs(['username', 'CB9yHm8Q$', 'yes']);
        $commandTester->execute([], ['interactive' => true]);

        $commandTester->assertCommandIsSuccessful();
    }
}
