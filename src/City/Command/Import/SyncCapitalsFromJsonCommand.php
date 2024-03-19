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

            foreach (Items::fromStream(fopen(Config::getCountriesCapitalsDataFilepath(), 'rb')) as $capital) {
                if (null === $capital->city) {
                    continue;
                }

                $country = $this->countryRepository->findByTitle($capital->country);

                if (!$country) {
                    echo "Country not found: {$capital->country}\n";
                    continue;
                }

                $city = $this->cityRepository->findByTitle($capital->city);

                if (!$city) {
                    echo "City not found for country '{$capital->country}': {$capital->city}\n";
                    continue;
                }

                $country->setCapital($city);
                $this->em->persist($country);
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
