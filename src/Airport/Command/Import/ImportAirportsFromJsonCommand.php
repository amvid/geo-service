<?php

declare(strict_types=1);

namespace App\Airport\Command\Import;

use App\Airport\Entity\Airport;
use App\Airport\Factory\AirportFactoryInterface;
use App\Airport\Repository\AirportRepositoryInterface;
use App\City\Repository\CityRepositoryInterface;
use App\Timezone\Repository\TimezoneRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Throwable;

#[AsCommand(
    name: 'app:import-airports',
    description: 'Import airports from json file.',
    hidden: false,
)]
class ImportAirportsFromJsonCommand extends Command
{
    public function __construct(
        private readonly AirportFactoryInterface     $airportFactory,
        private readonly AirportRepositoryInterface  $airportRepository,
        private readonly TimezoneRepositoryInterface $timezoneRepository,
        private readonly CityRepositoryInterface     $cityRepository,
        private readonly EntityManagerInterface      $em,
    )
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setHelp('This command will import airports from json file.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            $timezones = [];
            $cities = [];
            $imported = 0;
            $skipped = 0;

            $output->writeln('Importing...');

            foreach ($this->getAirports() as $a) {
                $exists = $this->airportRepository->findByTitle($a['Airport']);

                if ($exists) {
                    continue;
                }

                if (!isset($cities[$a['City']])) {
                    $city = $this->cityRepository->findByTitle($a['City']);

                    if (!$city) {
                        $output->writeln("City '{$a['City']}' not found. Skipping '{$a['IATA']}' airport");
                        continue;
                    }

                    $cities[$a->city] = $city;
                } else {
                    $city = $cities[$a->city];
                }

                if (!isset($timezones[$a['Tz']])) {
                    $timezone = $this->timezoneRepository->findByCode($a['Tz']);

                    if (!$timezone) {
                        $output->writeln("Timezone '{$a['Tz']}' not found. Skipping '{$a['IATA']}' airport");
                        continue;
                    }

                    $timezones[$a['Tz']] = $timezone;
                } else {
                    $timezone = $timezones[$a['Tz']];
                }

                $newAirport = $this->airportFactory
                    ->setAirport(new Airport())
                    ->setCity($city)
                    ->setTimezone($timezone)
                    ->setTitle($a['Airport'])
                    ->setIcao($a['ICAO'])
                    ->setIata($a['IATA'])
                    ->setLongitude((float)$a['Longitude'])
                    ->setLatitude((float)$a['Latitude'])
                    ->setAltitude((int)$a['Altitude'])
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
        } catch (Throwable $e) {
            $output->writeln('An error occurred: ' . $e->getMessage());
            return Command::FAILURE;
        }

        $output->writeln("Imported $imported airports, skipped $skipped");

        return Command::SUCCESS;
    }

}