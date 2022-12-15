<?php

declare(strict_types=1);

namespace App\Command;

use App\Entity\User;
use App\Repository\UserRepositoryInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Throwable;

#[AsCommand(
    name: 'app:create-user',
    description: 'Creates a new user.',
    hidden: false,
)]
class CreateUserCommand extends Command
{
    private const ARGUMENT_EMAIL = 'email';
    private const ARGUMENT_PASSWORD = 'password';

    public function __construct(
        private readonly UserPasswordHasherInterface $hasher,
        private readonly UserRepositoryInterface     $userRepository
    )
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setHelp('This command allows you to create a user')
            ->addArgument(self::ARGUMENT_EMAIL, InputArgument::REQUIRED, 'Email')
            ->addArgument(self::ARGUMENT_PASSWORD, InputArgument::REQUIRED, 'Password');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            $user = (new User())
                ->setEmail($input->getArgument(self::ARGUMENT_EMAIL))
                ->setRoles(['ROLE_ADMIN']);

            $user->setPassword(
                $this->hasher->hashPassword($user, $input->getArgument(self::ARGUMENT_PASSWORD))
            );

            $this->userRepository->save($user, true);
            $output->writeln('User successfully created.');
            return Command::SUCCESS;
        } catch (Throwable $e) {
            $output->writeln('An error occurred: ' . $e->getMessage());
            return Command::FAILURE;
        }
    }
}