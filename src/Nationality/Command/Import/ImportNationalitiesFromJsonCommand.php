<?php

declare(strict_types=1);

namespace App\Nationality\Command\Import;

use App\Application\Command\Import\Config;
use App\Application\Command\Import\ImportHelper;
use App\Nationality\Entity\Nationality;
use App\Nationality\Factory\NationalityFactoryInterface;
use App\Nationality\Repository\NationalityRepositoryInterface;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Throwable;

#[AsCommand(
    name: 'app:import-nationalities',
    description: 'Import nationalities from json file.',
    hidden: false,
)]
class ImportNationalitiesFromJsonCommand extends Command
{
    public function __construct(
        private readonly NationalityFactoryInterface $nationalityFactory,
        private readonly NationalityRepositoryInterface $nationalityRepository,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setHelp('This command will import nationalities from json file.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            $data = ImportHelper::getDataFromJsonFile(Config::getNationalitiesDataFilepath());
            $imported = 0;

            $output->writeln('Importing...');

            foreach ($data as $nation) {
                $nationality = $this->nationalityRepository->findByTitle($nation);

                if ($nationality) {
                    continue;
                }

                $nationality = $this->nationalityFactory
                    ->setNationality(new Nationality())
                    ->setTitle($nation)
                    ->create(Uuid::uuid4(), $nation);

                $this->nationalityRepository->save($nationality, true);
                $imported++;
            }
        } catch (Throwable $e) {
            $output->writeln('An error occurred: ' . $e->getMessage());
            return Command::FAILURE;
        }

        $output->writeln("Imported $imported nationalities.");
        return Command::SUCCESS;
    }
}
