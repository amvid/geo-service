<?php

declare(strict_types=1);

namespace App\Command\Import;

use App\Entity\Currency;
use App\Factory\CurrencyFactoryInterface;
use App\Repository\CurrencyRepositoryInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Throwable;

#[AsCommand(
    name: 'app:import-currencies',
    description: 'Import currencies from json file.',
    hidden: false,
)]
class ImportCurrenciesFromJsonCommand extends Command
{
    public function __construct(
        private readonly CurrencyFactoryInterface    $currencyFactory,
        private readonly CurrencyRepositoryInterface $currencyRepository,
    )
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setHelp('This command will import currencies from json file.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            $data = json_decode(
                file_get_contents(ImportConfig::getGeoDataFilepath()),
                true, 512, JSON_THROW_ON_ERROR
            );

            $existsArr = [];
            $imported = 0;

            foreach ($data as $country) {
                $code = $country['currency'];

                if (array_key_exists($code, $existsArr)) {
                    continue;
                }

                $exists = $this->currencyRepository->findByCode($code);

                if ($exists) {
                    $existsArr[$code] = true;
                    continue;
                }

                $name = $country['currency_name'];
                $symbol = $country['currency_symbol'];

                $currency = $this->currencyFactory
                    ->setCurrency(new Currency())
                    ->setCode($code)
                    ->setName($name)
                    ->setSymbol($symbol)
                    ->create();

                $this->currencyRepository->save($currency, true);
                $imported++;
            }
        } catch (Throwable $e) {
            $output->writeln('An error occurred: ' . $e->getMessage());
            return Command::FAILURE;
        }

        $output->writeln("Imported $imported currencies.");
        return Command::SUCCESS;
    }
}