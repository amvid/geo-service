<?php

declare(strict_types=1);

namespace App\Command\Import;

use App\Entity\Country;
use App\Factory\CountryFactoryInterface;
use App\Repository\CountryRepositoryInterface;
use App\Repository\CurrencyRepositoryInterface;
use App\SubRegion\Repository\SubRegionRepositoryInterface;
use App\Timezone\Repository\TimezoneRepositoryInterface;
use Doctrine\Common\Collections\ArrayCollection;
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

            $imported = 0;
            $total = count($data);

            $timezones = [];
            $currencies = [];
            $subRegions = [];

            foreach ($data as $country) {
                $existsCountry = $this->countryRepository->findByTitle($country['name']);

                if ($existsCountry) {
                    continue;
                }

                if (!array_key_exists($country['currency'], $currencies)) {
                    $currency = $this->currencyRepository->findByCode($country['currency']);

                    if (!$currency) {
                        $output->writeln('Currency not found: ' . $country['currency']);
                        $output->writeln($country['name'] . ' failed to import');
                        continue;
                    }

                    $currencies[$country['currency']] = $currency;
                }

                if (!array_key_exists($country['subregion'], $subRegions)) {
                    $subRegion = $this->subRegionRepository->findByTitle($country['subregion']);

                    if (!$subRegion) {
                        $output->writeln('Sub region not found: ' . $country['subregion']);
                        $output->writeln($country['name'] . ' failed to import');
                        continue;
                    }

                    $subRegions[$country['subregion']] = $subRegion;
                }

                $tzs = new ArrayCollection();

                foreach ($country['timezones'] as $tz) {
                    if (!array_key_exists($tz['zoneName'], $timezones)) {
                        $timezone = $this->timezoneRepository->findByCode($tz['zoneName']);

                        if (!$timezone) {
                            $output->writeln('Timezone not found: ' . $tz['zoneName']);
                            continue;
                        }

                        $timezones[$tz['zoneName']] = $timezone;
                    }

                    $tzs->add($timezones[$tz['zoneName']]);
                }

                $newCountry = $this->countryFactory
                    ->setCountry(new Country())
                    ->setCurrency($currencies[$country['currency']])
                    ->setSubRegion($subRegions[$country['subregion']])
                    ->setTimezones($tzs)
                    ->setTitle($country['name'])
                    ->setIso3($country['iso3'])
                    ->setIso2($country['iso2'])
                    ->setNumericCode($country['numeric_code'])
                    ->setPhoneCode($country['phone_code'])
                    ->setNativeTitle($country['native'])
                    ->setTld($country['tld'])
                    ->setLongitude((float)$country['longitude'])
                    ->setLatitude((float)$country['latitude'])
                    ->setFlag($country['emoji'])
                    ->create();

                $this->countryRepository->save($newCountry, true);
                $imported++;
            }
        } catch (Throwable $e) {
            $output->writeln('An error occurred: ' . $e->getMessage());
            return Command::FAILURE;
        }

        $output->writeln("Imported $imported of $total");
        return Command::SUCCESS;
    }
}