<?php

declare(strict_types=1);

namespace App\State\Command\Import;

use App\Application\Command\Import\Config;
use App\Application\Command\Import\ImportHelper;
use App\Country\Repository\CountryRepositoryInterface;
use App\State\Entity\State;
use App\State\Factory\StateFactoryInterface;
use App\State\Repository\StateRepositoryInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Throwable;

#[AsCommand(
    name: 'app:import-states',
    description: 'Import states from json file.',
    hidden: false,
)]
class ImportStatesFromJsonCommand extends Command
{
    public function __construct(
        private readonly StateFactoryInterface      $stateFactory,
        private readonly StateRepositoryInterface   $stateRepository,
        private readonly CountryRepositoryInterface $countryRepository,
    )
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setHelp('This command will import states from json file.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            $states = ImportHelper::getDataFromJsonFile(Config::getStatesDataFilepath());

            $countriesArr = [];
            $imported = 0;

            $output->writeln('Importing...');

            foreach ($states as $state) {
                $exists = $this->stateRepository->findByTitle($state['name']);

                if ($exists) {
                    continue;
                }

                $country = null;
                if (isset($countriesArr[$state['country_code']])) {
                    $country = $countriesArr[$state['country_code']];
                } else {
                    $country = $this->countryRepository->findByIso2($state['country_code']);

                    if (!$country) {
                        $output->writeln('Country not found: ' . $state['country_code']);
                        continue;
                    }

                    $countriesArr[$state['country_code']] = $country;
                }

                $newState = $this->stateFactory
                    ->setState(new State())
                    ->setTitle($state['name'])
                    ->setCode($state['state_code'])
                    ->setCountry($country)
                    ->setType($state['type'])
                    ->setLatitude((float)$state['latitude'])
                    ->setLongitude((float)$state['longitude'])
                    ->create();

                $this->stateRepository->save($newState, true);
                $imported++;
            }
        } catch (Throwable $e) {
            $output->writeln('An error occurred: ' . $e->getMessage());
            return Command::FAILURE;
        }

        $output->writeln("Imported $imported states.");
        return Command::SUCCESS;
    }
}