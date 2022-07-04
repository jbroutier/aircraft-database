<?php

declare(strict_types=1);

namespace App\Command;

use App\Repository\UserRepository;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'user:delete',
    description: 'Delete an existing user'
)]
class UserDeleteCommand extends Command
{
    public function __construct(protected readonly UserRepository $repository)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->addArgument('email', InputArgument::REQUIRED, 'The user email address');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        if (is_null($user = $this->repository->findOneBy(['email' => $input->getArgument('email')]))) {
            $io->error('The user could not be found.');

            return Command::FAILURE;
        }

        $this->repository->remove($user, true);
        $io->success('The user has been deleted.');

        return Command::SUCCESS;
    }
}
