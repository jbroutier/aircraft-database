<?php

declare(strict_types=1);

namespace App\Command;

use App\Entity\AircraftModel;
use App\Repository\AircraftModelRepository;
use Doctrine\ORM\Query;
use League\Csv\Writer;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'dump:aircraft-models',
    description: 'Dump the aircraft models',
)]
class DumpAircraftModelsCommand extends Command
{
    public function __construct(protected readonly AircraftModelRepository $repository)
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        /** @var AircraftModel[] $aircraftModels */
        $aircraftModels = $this->repository
            ->createQueryBuilder('am')
            ->select('PARTIAL am.{id, aircraftFamily, engineCount, engineFamily, name}')
            ->addSelect('PARTIAL m.{id, name}')
            ->leftJoin('am.manufacturer', 'm')
            ->getQuery()
            ->setHint(Query::HINT_FORCE_PARTIAL_LOAD, true)
            ->getResult();

        $csv = Writer::createFromPath('dump/aircraft-models.csv', 'w');
        $csv->insertOne(['name', 'manufacturer', 'aircraft-family', 'engine-type', 'engine-count']);

        foreach ($aircraftModels as $aircraftModel) {
            $csv->insertOne([
                $aircraftModel->getName(),
                $aircraftModel->getManufacturer()?->getName(),
                $aircraftModel->getAircraftFamily()?->label(),
                $aircraftModel->getEngineFamily()?->label(),
                $aircraftModel->getEngineCount(),
            ]);
        }

        $io->success('The aircraft models have been dumped.');

        return Command::SUCCESS;
    }
}
