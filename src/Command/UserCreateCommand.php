<?php

declare(strict_types=1);

namespace App\Command;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotCompromisedPassword;
use Symfony\Component\Validator\Constraints\NotEqualTo;
use Symfony\Component\Validator\Validation;

#[AsCommand(
    name: 'user:create',
    description: 'Create a new user'
)]
class UserCreateCommand extends Command
{
    public function __construct(
        protected readonly EntityManagerInterface $entityManager,
        protected readonly UserPasswordHasherInterface $userPasswordHasher
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $question = new Question('Please enter the user name');
        $question->setValidator(
            Validation::createCallable(
                new NotBlank(),
                new Length(min: 4, max: 30)
            )
        );
        $username = $io->askQuestion($question);

        $question = new Question('Please enter the user password');
        $question->setValidator(
            Validation::createCallable(
                new NotBlank(),
                new Length(min: 8),
                new NotCompromisedPassword(),
                new NotEqualTo(value: $username)
            )
        );
        $password = $io->askQuestion($question);

        $question = new ConfirmationQuestion('Grant user admin privileges?', false);
        $admin = $io->askQuestion($question);

        $user = new User();
        $user
            ->setPassword($this->userPasswordHasher->hashPassword($user, $password))
            ->setUsername($username);

        if ($admin === true) {
            $user->setRoles(['ROLE_ADMIN']);
        }

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        $io->success('User has been created.');

        return Command::SUCCESS;
    }
}
