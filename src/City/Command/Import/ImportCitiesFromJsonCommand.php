<?php

declare(strict_types=1);

namespace App\City\Command\Import;

use App\Application\Command\Import\Config;
use App\City\Entity\City;
use App\City\Factory\CityFactoryInterface;
use App\City\Repository\CityRepositoryInterface;
use App\Country\Repository\CountryRepositoryInterface;
use App\State\Repository\StateRepositoryInterface;
use JsonMachine\Items;
use JsonStreamingParser\Parser;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Throwable;

#[AsCommand(
    name: 'app:import-cities',
    description: 'Import cities from json file.',
    hidden: false,
)]
class ImportCitiesFromJsonCommand extends Command
{
    public function __construct(
        private readonly StateRepositoryInterface   $stateRepository,
        private readonly CountryRepositoryInterface $countryRepository,
        private readonly CityRepositoryInterface    $cityRepository,
        private readonly CityFactoryInterface       $cityFactory,
    )
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setHelp('This command will import cities from json file.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            $countries = [];
            $states = [];
            $imported = 0;

            $output->writeln('Importing...');

            foreach (Items::fromStream(fopen(Config::getCitiesDataFilepath(), 'rb')) as $city) {
                $exists = $this->cityRepository->findByTitle($city->name);

                if ($exists) {
                    continue;
                }

                if (!isset($countries[$city->country_code])) {
                    $country = $this->countryRepository->findByIso2($city->country_code);

                    if (!$country) {
                        $output->writeln("Country '$city->country_code' not found");
                        continue;
                    }

                    $countries[$city->country_name] = $country;
                } else {
                    $country = $countries[$city->country_code];
                }

                $state = null;

                if (!empty($city->state_code)) {
                    if (!isset($states[$city->state_code])) {
                        $state = $this->stateRepository->findByCode($city->state_code);

                        if (!$state) {
                            $output->writeln("State '$city->state_code' not found");
                            continue;
                        }

                        $states[$city->state_code] = $state;
                    } else {
                        $state = $states[$city->state_code];
                    }
                }

                $newCity = $this->cityFactory
                    ->setCity(new City())
                    ->setCountry($country)
                    ->setState($state)
                    ->setTitle($city->name)
                    ->setLongitude((float)$city->longitude)
                    ->setLatitude((float)$city->latitude)
                    ->create();

                $this->cityRepository->save($newCity, true);
                $imported++;

                if ($imported % 1000 === 0) {
                    $output->writeln("Imported $imported cities... Still working...");
                }
            }
        } catch (Throwable $e) {
            $output->writeln('An error occurred: ' . $e->getMessage());
            return Command::FAILURE;
        }

        $output->writeln("Imported $imported cities");

        return Command::SUCCESS;
    }
}