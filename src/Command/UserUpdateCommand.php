<?php

declare(strict_types=1);

namespace App\Command;

use App\Repository\UserRepository;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validation;

#[AsCommand(
    name: 'user:update',
    description: 'Update an existing user'
)]
class UserUpdateCommand extends Command
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

        $firstName = strval(
            $io->askQuestion(
                (new Question('First name', $user->getFirstName()))
                    ->setValidator(
                        Validation::createCallable(
                            new Assert\NotBlank(),
                            new Assert\Length(max: 255),
                        )
                    )
            )
        );

        $lastName = strval(
            $io->askQuestion(
                (new Question('Last name', $user->getLastName()))
                    ->setValidator(
                        Validation::createCallable(
                            new Assert\NotBlank(),
                            new Assert\Length(max: 255),
                        )
                    )
            )
        );

        $plainPassword = strval(
            $io->askQuestion(
                (new Question('Password'))
                    ->setHidden(true)
                    ->setValidator(
                        Validation::createCallable(
                            new Assert\Length(min: 8),
                            new Assert\NotCompromisedPassword(),
                            new Assert\NotEqualTo(value: $input->getArgument('email'))
                        )
                    )
            )
        );

        $admin = boolval(
            $io->askQuestion(
                new ConfirmationQuestion(
                    'Grant user admin privileges',
                    in_array('ROLE_ADMIN', $user->getRoles(), true)
                )
            )
        );

        $user
            ->setFirstName($firstName)
            ->setLastName($lastName)
            ->setPlainPassword($plainPassword)
            ->setRoles($admin ? ['ROLE_ADMIN'] : []);

        $this->repository->add($user, true);
        $io->success('The user has been updated.');

        return Command::SUCCESS;
    }
}
