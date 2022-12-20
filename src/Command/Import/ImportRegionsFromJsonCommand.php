<?php

declare(strict_types=1);

namespace App\Command\Import;

use App\Entity\Region;
use App\Factory\RegionFactoryInterface;
use App\Repository\RegionRepositoryInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Throwable;

#[AsCommand(
    name: 'app:import-regions',
    description: 'Import regions from json file.',
    hidden: false,
)]
class ImportRegionsFromJsonCommand extends Command
{
    public function __construct(
        private readonly RegionFactoryInterface $regionFactory,
        private readonly RegionRepositoryInterface $regionRepository,
    )
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setHelp('This command will import regions from json file.');
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
                $region = $country['region'];

                if ($region === '') {
                    continue;
                }

                if (array_key_exists($region, $existsArr)) {
                    continue;
                }

                $existsRegion = $this->regionRepository->findByTitle($region);

                if ($existsRegion) {
                    $existsArr[$region] = true;
                    continue;
                }

                $regionEntity = $this->regionFactory
                    ->setRegion(new Region())
                    ->setTitle($region)
                    ->create();

                $this->regionRepository->save($regionEntity, true);
                $imported++;
            }
        } catch (Throwable $e) {
            $output->writeln('An error occurred: ' . $e->getMessage());
            return Command::FAILURE;
        }

        $output->writeln("Imported $imported regions.");
        return Command::SUCCESS;
    }
}