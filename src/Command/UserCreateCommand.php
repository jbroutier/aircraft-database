<?php

declare(strict_types=1);

namespace App\Command;

use App\Entity\User;
use App\Enum\RegistrationMethod;
use App\Repository\UserRepository;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validation;

#[AsCommand(
    name: 'user:create',
    description: 'Create a new user'
)]
class UserCreateCommand extends Command
{
    public function __construct(protected readonly UserRepository $repository)
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $email = strval(
            $io->askQuestion(
                (new Question('Email address'))
                    ->setValidator(
                        Validation::createCallable(
                            new Assert\NotBlank(),
                            new Assert\Email(),
                            new Assert\Length(max: 180)
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
                            new Assert\NotBlank(),
                            new Assert\Length(min: 8),
                            new Assert\NotCompromisedPassword(),
                            new Assert\NotEqualTo(value: $email)
                        )
                    )
            )
        );

        $firstName = strval(
            $io->askQuestion(
                (new Question('First name'))
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
                (new Question('Last name'))
                    ->setValidator(
                        Validation::createCallable(
                            new Assert\NotBlank(),
                            new Assert\Length(max: 255),
                        )
                    )
            )
        );

        $admin = boolval($io->askQuestion(new ConfirmationQuestion('Grant user admin privileges', false)));

        $user = (new User())
            ->setConsenting(true)
            ->setEmail($email)
            ->setEnabled(true)
            ->setFirstName($firstName)
            ->setLastName($lastName)
            ->setPlainPassword($plainPassword)
            ->setRegistrationMethod(RegistrationMethod::CommandLine)
            ->setRoles($admin ? ['ROLE_ADMIN'] : []);

        $this->repository->add($user, true);
        $io->success('The user has been created.');

        return Command::SUCCESS;
    }
}
