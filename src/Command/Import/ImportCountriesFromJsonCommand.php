<?php

declare(strict_types=1);

namespace App\Command\Import;

use App\Factory\CountryFactoryInterface;
use App\Repository\CountryRepositoryInterface;
use App\Repository\CurrencyRepositoryInterface;
use App\Repository\SubRegionRepositoryInterface;
use App\Repository\TimezoneRepositoryInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Throwable;

#[AsCommand(
    name: 'app:import-countries',
    description: 'Import countries from json file.',
    hidden: false,
)]
class ImportCountriesFromJsonCommand extends Command
{
    public function __construct(
        private readonly CountryFactoryInterface $countryFactory,
        private readonly CountryRepositoryInterface $countryRepository,
        private readonly CurrencyRepositoryInterface $currencyRepository,
        private readonly SubRegionRepositoryInterface $subRegionRepository,
        private readonly TimezoneRepositoryInterface $timezoneRepository,
    )
    {
        parent::__construct();
    }

    protected function configure()
    {
        $this->setHelp('This command will import countries from json file.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        try {
            $data = ImportHelper::getDataFromJsonFile(Config::getGeoDataFilepath());

            $timezones = [];
            $currencies = [];
            $subRegions = [];

            foreach ($data as $country) {

            }
        } catch (Throwable $e) {
            $output->writeln('An error occurred: ' . $e->getMessage());
            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }
}