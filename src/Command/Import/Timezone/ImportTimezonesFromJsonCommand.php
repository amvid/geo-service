<?php

declare(strict_types=1);

namespace App\Command\Import\Timezone;

use App\Factory\TimezoneFactory;
use App\Repository\TimezoneRepositoryInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Throwable;

#[AsCommand(
    name: 'app:import-timezones',
    description: 'Import timezones from json file.',
    hidden: false,
)]
class ImportTimezonesFromJsonCommand extends Command
{
    public function __construct(
        private readonly TimezoneRepositoryInterface $timezoneRepository,
    )
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setHelp('This command will import timezones from json file.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            $timezones = json_decode(
                file_get_contents(getcwd() . '/data/timezone/timezones.json'),
                true, 512, JSON_THROW_ON_ERROR
            );

            $imported = 0;
            $skipped = 0;
            $skippedTimezones = [];

            $output->writeln('Importing...');

            foreach ($timezones as $timezone) {
                $exists = $this->timezoneRepository->findByCode($timezone['tzCode']);

                if ($exists) {
                    $skippedTimezones[] = $timezone['tzCode'];
                    $skipped++;
                    continue;
                }

                $tz = TimezoneFactory::builder()
                    ->setTitle($timezone['label'])
                    ->setCode($timezone['tzCode'])
                    ->setUtc($timezone['utc'])
                    ->create();

                $this->timezoneRepository->save($tz, true);
                $imported++;
            }
        } catch (Throwable $e) {
            $output->writeln("An error occurred: {$e->getMessage()}");
            return Command::FAILURE;
        }

        $message = "Imported $imported timezones, skipped $skipped.";

        if ($skipped > 0) {
            $message .=
                "\n===================================\n"
                . implode("\n", $skippedTimezones) .
                "\n===================================";
        }

        $output->writeln($message);

        return Command::SUCCESS;
    }
}