<?php

declare(strict_types=1);

namespace App\City\Command\Import;

use App\Application\Command\Import\Config;
use App\City\Entity\City;
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
    name: 'app:sync-capitals',
    description: 'Sync capitals from json file.',
    hidden: false,
)]
class SyncCapitalsFromJsonCommand extends Command
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
        $this->setHelp('This command will sync capitals with countries from json file.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            $synced = 0;

            $output->writeln('Syncing...');

            foreach (Items::fromStream(fopen(Config::getGeoDataFilepath(), 'rb')) as $country) {
                if (empty($country->capital)) {
                    continue;
                }

                $countryEntity = $this->countryRepository->findByTitle($country->name);

                if (!$countryEntity) {
                    echo "Country not found: {$country->name}\n";
                    continue;
                }

                $city = $this->cityRepository->findByTitleAndCountry($country->capital, $countryEntity);

                if (!$city) {
                    $city = new City();
                    $city->setTitle($country->capital);
                    $city->setCountry($countryEntity);
                    $city->setAltitude(0);
                    $city->setLatitude(0.0);
                    $city->setLongitude(0.0);
                    $this->cityRepository->save($city);
                }

                $countryEntity->setCapital($city);
                $this->em->persist($countryEntity);
                $this->em->flush();
                $synced++;
            }
        } catch (Throwable $e) {
            $output->writeln('An error occurred: ' . $e->getMessage());
            return Command::FAILURE;
        }

        $output->writeln("Synced $synced capitals");

        return Command::SUCCESS;
    }
}
