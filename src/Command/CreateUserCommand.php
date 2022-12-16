<?php

declare(strict_types=1);

namespace App\Command;

use App\Entity\User;
use App\Factory\UserFactoryInterface;
use App\Repository\UserRepositoryInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\Question;
use Throwable;

#[AsCommand(
    name: 'app:create-user',
    description: 'Creates a new user.',
    hidden: false,
)]
class CreateUserCommand extends Command
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
        private readonly UserFactoryInterface    $userFactory,
    )
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setHelp('This command allows you to create a user');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('User generator!');
        $output->writeln('===============');

        $dialog = $this->getHelper('question');

        $email = $dialog->ask($input, $output, new Question('Please enter email: '));

        $plainPassword = $dialog->ask(
            $input,
            $output,
            (new Question('Please enter password: '))->setHidden(true)
        );

        $role = $dialog->ask(
            $input,
            $output,
            new ChoiceQuestion('Choose role: ', [User::ADMIN, User::USER], 0)
        );

        try {
            $exists = $this->userRepository->findByEmail($email);

            if ($exists) {
                $output->writeln('This email has been taken');
                return Command::FAILURE;
            }

            $user = $this->userFactory
                ->setEmail($email)
                ->setRoles([$role])
                ->setPassword($plainPassword)
                ->create();

            $this->userRepository->save($user, true);
            $output->writeln("User '$email' successfully created.");
            return Command::SUCCESS;
        } catch (Throwable $e) {
            $output->writeln('An error occurred: ' . $e->getMessage());
            return Command::FAILURE;
        }
    }
}