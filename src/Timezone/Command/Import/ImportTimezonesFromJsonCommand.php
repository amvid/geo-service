<?php

declare(strict_types=1);

namespace App\Timezone\Command\Import;

use App\Application\Command\Import\Config;
use App\Application\Command\Import\ImportHelper;
use App\Timezone\Entity\Timezone;
use App\Timezone\Factory\TimezoneFactoryInterface;
use App\Timezone\Repository\TimezoneRepositoryInterface;
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
        private readonly TimezoneFactoryInterface $timezoneFactory,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setHelp('This command will import timezones from json file.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            $data = ImportHelper::getDataFromJsonFile(Config::getGeoDataFilepath());

            $imported = 0;
            $skip = [];

            $output->writeln('Importing...');

            foreach ($data as $country) {
                foreach ($country['timezones'] as $timezone) {
                    $exists = $this->timezoneRepository->findByCode($timezone['zoneName']);

                    if ($exists) {
                        continue;
                    }

                    if (isset($skip[$timezone['zoneName']])) {
                        continue;
                    }

                    $skip[$timezone['zoneName']] = true;
                    $tzName = "{$timezone['tzName']} {$timezone['zoneName']} ({$timezone['abbreviation']})";

                    $tz = $this->timezoneFactory
                        ->setTimezone(new Timezone())
                        ->setTitle($tzName)
                        ->setCode($timezone['zoneName'])
                        ->setUtc($timezone['gmtOffsetName'])
                        ->create();

                    $this->timezoneRepository->save($tz, true);
                    $imported++;
                }
            }
        } catch (Throwable $e) {
            $output->writeln("An error occurred: {$e->getMessage()}");
            return Command::FAILURE;
        }

        $message = "Imported $imported timezones.";

        $output->writeln($message);

        return Command::SUCCESS;
    }
}
