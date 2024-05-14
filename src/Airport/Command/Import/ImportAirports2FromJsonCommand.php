<?php

declare(strict_types=1);

namespace App\Airport\Command\Import;

use App\Airport\Entity\Airport;
use App\Airport\Factory\AirportFactoryInterface;
use App\Airport\Repository\AirportRepositoryInterface;
use App\Application\Command\Import\Config;
use App\City\Entity\City;
use App\City\Factory\CityFactoryInterface;
use App\City\Repository\CityRepositoryInterface;
use App\State\Repository\StateRepositoryInterface;
use App\Country\Repository\CountryRepositoryInterface;
use App\State\Factory\StateFactoryInterface;
use App\Timezone\Repository\TimezoneRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use JsonMachine\Items;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Throwable;

#[AsCommand(
    name: 'app:import-airports2',
    description: 'Import airports 2 from json file.',
    hidden: false,
)]
class ImportAirports2FromJsonCommand extends Command
{
    public function __construct(
        private readonly AirportFactoryInterface $airportFactory,
        private readonly AirportRepositoryInterface $airportRepository,
        private readonly TimezoneRepositoryInterface $timezoneRepository,
        private readonly CityRepositoryInterface $cityRepository,
        private readonly CityFactoryInterface $cityFactory,
        private readonly StateRepositoryInterface $stateRepository,
        private readonly StateFactoryInterface $stateFactory,
        private readonly CountryRepositoryInterface $countryRepository,
        private readonly EntityManagerInterface $em,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setHelp('This command will import airports 2 from json file.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            $timezones = [];
            $cities = [];
            $imported = 0;
            $skipped = 0;

            $output->writeln('Importing...');

            foreach (Items::fromStream(fopen(Config::getAirports2DataFilepath(), 'rb')) as $a) {
                if (!is_array($a)) {
                    continue;
                }

                foreach ($a as $airport) {
                    if (empty($airport->Iata) || empty($airport->CityAscii) || true === $airport->IsClosed) {
                        continue;
                    }

                    $exists = $this->airportRepository->findByIata($airport->Iata);

                    if ($exists) {
                        $exists->setRank($airport->Rank ?? 0.0);
                        $this->airportRepository->save($exists, true);

                        continue;
                    }

                    $country = $this->countryRepository->findByIso2($airport->CountryIso2);

                    if (!$country) {
                        $output->writeln("Country '$airport->CountryIso2' not found. Skipping '$airport->Iata' airport");
                        continue;
                    }

                    if (!isset($cities[$airport->CityAscii . $airport->CountryIso2])) {
                        $city = $this->cityRepository->findByTitleAndCountry($airport->CityAscii, $country);

                        if (!$city) {
                            $output->writeln("City '$airport->CityAscii' not found. Creating...");

                            $state = null;

                            if (isset($airport->StateCode)) {
                                $state = $this->stateRepository->findByCode($airport->StateCode);

                                if (!$state) {
                                    $output->writeln("State '$airport->StateCode' not found. Skipping '$airport->Iata' airport");
                                    $skipped++;
                                    continue;
                                }
                            }

                            $city = $this->cityFactory
                                ->setCity(new City())
                                ->setTitle($airport->CityAscii)
                                ->setIata($airport->CityCode)
                                ->setLongitude((float)$airport->Longitude)
                                ->setLatitude((float)$airport->Latitude)
                                ->setAltitude((int)$airport->Elevation)
                                ->setState($state)
                                ->setCountry($country)
                                ->create();
                        }

                        if (!empty($airport->CityCode)) {
                            $existsCityIata = $this->cityRepository->findByIata($airport->CityCode);

                            if ($existsCityIata) {
                                $existsCityIata->setIata(null);
                                $this->cityRepository->save($existsCityIata, true);
                            }

                            $city->setIata($airport->CityCode);
                            $this->cityRepository->save($city, true);
                        }

                        $cities[$airport->CityAscii . $airport->CountryIso2] = $city;
                    } else {
                        $city = $cities[$airport->CityAscii . $airport->CountryIso2];
                    }

                    if (!isset($timezones[$airport->TimezoneId])) {
                        $timezone = $this->timezoneRepository->findByCode($airport->TimezoneId);

                        if (!$timezone) {
                            $output->writeln("Timezone '{$airport->TimezoneId}' not found. Skipping '$airport->Iata' airport");
                            continue;
                        }

                        $timezones[$airport->TimezoneId] = $timezone;
                    } else {
                        $timezone = $timezones[$airport->TimezoneId];
                    }

                    $newAirport = $this->airportFactory
                        ->setAirport(new Airport())
                        ->setCity($city)
                        ->setTimezone($timezone)
                        ->setTitle($airport->Name)
                        ->setIcao($airport->Icao ?? null)
                        ->setIata($airport->Iata)
                        ->setRank($airport->Rank ?? 0.0)
                        ->setLongitude((float)$airport->Longitude)
                        ->setLatitude((float)$airport->Latitude)
                        ->setAltitude((int)$airport->Elevation)
                        ->create();

                    $this->airportRepository->save($newAirport, true);
                    $imported++;

                    if ($imported % 2000 === 0) {
                        $this->em->clear();
                        $timezones = [];
                        $cities = [];
                        gc_collect_cycles();
                        $output->writeln("Imported $imported airports... Still working...");
                    }
                }
            }
        } catch (Throwable $e) {
            $output->writeln('An error occurred: ' . $e->getMessage());
            return Command::FAILURE;
        }

        $output->writeln("Imported $imported airports, skipped $skipped");

        return Command::SUCCESS;
    }
}
