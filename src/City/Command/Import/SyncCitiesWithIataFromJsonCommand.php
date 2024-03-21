<?php

declare(strict_types=1);

namespace App\City\Command\Import;

use App\Application\Command\Import\Config;
use App\City\Repository\CityRepositoryInterface;
use App\Country\Repository\CountryRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use JsonMachine\Items;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Throwable;

#[AsCommand(
    name: 'app:sync-cities-with-iata',
    description: 'Sync cities with iata from json file.',
    hidden: false,
)]
class SyncCitiesWithIataFromJsonCommand extends Command
{
    public function __construct(
        private readonly CountryRepositoryInterface $countryRepository,
        private readonly CityRepositoryInterface $cityRepository,
        private readonly EntityManagerInterface $em,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setHelp('This command will sync cities with iata from json file.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            $synced = 0;
            $failed = 0;

            $output->writeln('Syncing...');

            foreach (Items::fromStream(fopen(Config::getCitiesIataDataFilepath(), 'rb')) as $data) {
                $country = $this->countryRepository->findByIso2($data->country_code);

                if (!$country) {
                    echo "Country not found by code: {$data->country_code}\n";
                    $failed++;
                    continue;
                }

                $city = $this->cityRepository->findByTitleAndCountry($data->name, $country);

                if (!$city) {
                    $output->writeln("City not found by country '{$country->getTitle()}' and name: {$data->name}");
                    $failed++;
                    continue;
                }

                // if (!$city) {
                //     $city = new City();
                //     $city->setTitle($country->capital);
                //     $city->setCountry($countryEntity);
                //     $city->setAltitude(0);
                //     $city->setLatitude(0.0);
                //     $city->setLongitude(0.0);
                //     $this->cityRepository->save($city);
                // }

                $city->setIata($data->iso_3166_3);
                $this->em->persist($city);
                $this->em->flush();
                $synced++;
            }
        } catch (Throwable $e) {
            $output->writeln('An error occurred: ' . $e->getMessage());
            return Command::FAILURE;
        }

        $output->writeln("Synced $synced cities with iata and $failed failed");

        return Command::SUCCESS;
    }
}
