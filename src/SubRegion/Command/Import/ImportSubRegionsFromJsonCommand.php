<?php

declare(strict_types=1);

namespace App\SubRegion\Command\Import;

use App\Application\Command\Import\Config;
use App\Application\Command\Import\ImportHelper;
use App\Region\Repository\RegionRepositoryInterface;
use App\SubRegion\Entity\SubRegion;
use App\SubRegion\Factory\SubRegionFactoryInterface;
use App\SubRegion\Repository\SubRegionRepositoryInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Throwable;

#[AsCommand(
    name: 'app:import-subregions',
    description: 'Import regions from json file.',
    hidden: false,
)]
class ImportSubRegionsFromJsonCommand extends Command
{
    public function __construct(
        private readonly SubRegionFactoryInterface $subRegionFactory,
        private readonly SubRegionRepositoryInterface $subRegionRepository,
        private readonly RegionRepositoryInterface $regionRepository,
    )
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setHelp('This command will import sub regions from json file.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            $data = ImportHelper::getDataFromJsonFile(Config::getGeoDataFilepath());

            $regionsArr = [];
            $existsArr = [];
            $imported = 0;

            foreach ($data as $country) {
                $subRegionTitle = $country['subregion'];

                if ($subRegionTitle === '') {
                    continue;
                }

                if (array_key_exists($subRegionTitle, $existsArr)) {
                    continue;
                }

                $existsSubRegion = $this->subRegionRepository->findByTitle($subRegionTitle);

                if ($existsSubRegion) {
                    $existsArr[$subRegionTitle] = true;
                    continue;
                }

                $regionTitle = $country['region'];

                if ($regionTitle === '') {
                    continue;
                }

                if (!array_key_exists($regionTitle, $regionsArr)) {
                    $region = $this->regionRepository->findByTitle($regionTitle);

                    if (!$region) {
                        $output->writeln('Region not found: ' . $regionTitle);
                        continue;
                    }

                    $regionsArr[$regionTitle] = $region;
                }

                $region = $regionsArr[$regionTitle];

                $subRegionEntity = $this->subRegionFactory
                    ->setSubRegion(new SubRegion())
                    ->setRegion($region)
                    ->setTitle($subRegionTitle)
                    ->create();

                $this->subRegionRepository->save($subRegionEntity, true);
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