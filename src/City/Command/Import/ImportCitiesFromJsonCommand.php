<?php

declare(strict_types=1);

namespace App\City\Command\Import;

use App\Application\Command\Import\Config;
use App\City\Entity\City;
use App\City\Factory\CityFactoryInterface;
use App\City\Repository\CityRepositoryInterface;
use App\Country\Repository\CountryRepositoryInterface;
use App\State\Repository\StateRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use JsonMachine\Items;
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
        private readonly StateRepositoryInterface $stateRepository,
        private readonly CountryRepositoryInterface $countryRepository,
        private readonly CityRepositoryInterface $cityRepository,
        private readonly CityFactoryInterface $cityFactory,
        private readonly EntityManagerInterface $em,
    ) {
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
                if (empty($city->city)) {
                    continue;
                }


                if (!isset($countries[$city->country])) {
                    $country = $this->countryRepository->findByIso2($city->country);

                    if (!$country) {
                        $output->writeln("Country '{$city->country}' not found");
                        continue;
                    }

                    $countries[$city->country] = $country;
                } else {
                    $country = $countries[$city->country];
                }

                $exists = $this->cityRepository->findByTitleAndCountry($city->city, $country);

                if ($exists) {
                    continue;
                }

                $state = null;

                if (!empty($city->state)) {
                    if (str_contains($city->state, '-')) {
                        $city->state = str_replace('-', ' ', $city->state);
                    }

                    if (!isset($states[$city->state])) {
                        $state = $this->stateRepository->findByTitle($city->state);
                        $states[$city->state] = $state;
                    } else {
                        $state = $states[$city->state];
                    }
                }

                $newCity = $this->cityFactory
                    ->setCity(new City())
                    ->setCountry($country)
                    ->setState($state)
                    ->setTitle($city->city)
                    ->setLongitude((float)$city->lon)
                    ->setLatitude((float)$city->lat)
                    ->create();

                $this->cityRepository->save($newCity, true);
                $imported++;

                if ($imported % 2500 === 0) {
                    $this->em->clear();
                    $countries = [];
                    $states = [];
                    gc_collect_cycles();
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
