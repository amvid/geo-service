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
use App\Country\Repository\CountryRepositoryInterface;
use App\Timezone\Entity\Timezone;
use App\Timezone\Repository\TimezoneRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:import-airports3',
    description: 'Import airports 3 from csv file',
    hidden: false,
)]
class ImportAirports3FromCsvCommand extends Command
{
    public function __construct(
        private readonly AirportFactoryInterface $airportFactory,
        private readonly AirportRepositoryInterface $airportRepository,
        private readonly TimezoneRepositoryInterface $timezoneRepository,
        private readonly CityRepositoryInterface $cityRepository,
        private readonly CityFactoryInterface $cityFactory,
        private readonly CountryRepositoryInterface $countryRepository,
        private readonly EntityManagerInterface $em,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setHelp('This command will import airports 3 from csv file.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $existsCount = 0;
        $imported = 0;

        try {
            foreach ($this->getCsvRecords(Config::getAirports3DataFilepath()) as $record) {
                if (!preg_match('/^[a-zA-Z0-9]{3}$/', $record['iata'])) {
                    continue;
                }

                $exists = $this->airportRepository->findByIata($record['iata']);

                if ($exists) {
                    $existsCount++;
                    continue;
                }

                $country = $this->countryRepository->findByTitle($record['country']);

                if (!$country) {
                    error_log("Country is not found: {$record['country']}, {$record['iata']}, {$record['id']}");
                    continue;
                }

                $city = $this->cityRepository->findByTitleAndCountry($record['city'], $country);

                if (!$city) {
                    $city = $this->cityFactory
                        ->setCity(new City())
                        ->setTitle($record['city'])
                        ->setCountry($country)
                        ->setLongitude(0.0)
                        ->setLatitude(0.0)
                        ->create();

                    $this->cityRepository->save($city, true);
                }


                $airport = $this->airportFactory
                    ->setAirport(new Airport())
                    ->setTitle($record['name'])
                    ->setIcao($record['icao'] === 'N' ? null : $record['icao'])
                    ->setIata($record['iata'])
                    ->setCity($city)
                    ->setLongitude((float) $record['longitude'])
                    ->setLatitude((float) $record['latitude'])
                    ->setTimezone(
                        $country
                            ->getTimezones()
                            ->findFirst(
                                fn(int $key, Timezone $tz) => substr($tz->getUtc(), 3) === $record['tz_timezone']
                            )
                            ?? $country->getTimezones()->first()
                    )
                    ->create();

                $this->airportRepository->save($airport, true);
                $imported++;

                if ($imported % 2000 === 0) {
                    $this->em->clear();
                    gc_collect_cycles();
                    $output->writeln("Imported $imported airports... Still working...");
                }
            }

            $output->writeln("Skipped: $existsCount, imported: $imported");

            return Command::SUCCESS;
        } catch (\Throwable $e) {
            $output->writeln($e->getMessage());
            return Command::FAILURE;
        }
    }

    private function getCsvRecords(string $csvPath): iterable
    {
        if (($handle = fopen($csvPath, 'r')) !== false) {
            $headers = fgetcsv($handle, 0, ',');
            $headerCount = count($headers);

            while (($data = fgetcsv($handle, 0, ',')) !== false) {
                $dataCount = count($data);

                if ($dataCount !== $headerCount) {
                    continue;
                }

                yield array_combine($headers, $data);
            }

            fclose($handle);
        }
    }
}
