<?php

declare(strict_types=1);

namespace App\Command;

use App\Entity\EngineModel;
use App\Repository\EngineModelRepository;
use Doctrine\ORM\Query;
use League\Csv\Writer;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'dump:engine-models',
    description: 'Dump the engine models',
)]
class DumpEngineModelsCommand extends Command
{
    public function __construct(protected readonly EngineModelRepository $repository)
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        /** @var EngineModel[] $engineModels */
        $engineModels = $this->repository
            ->createQueryBuilder('em')
            ->select('PARTIAL em.{id, engineFamily, name}')
            ->addSelect('PARTIAL m.{id, name}')
            ->leftJoin('em.manufacturer', 'm')
            ->getQuery()
            ->setHint(Query::HINT_FORCE_PARTIAL_LOAD, true)
            ->getResult();

        $csv = Writer::createFromPath('dump/engine-models.csv', 'w');
        $csv->insertOne(['name', 'manufacturer', 'engine-type']);

        foreach ($engineModels as $engineModel) {
            $csv->insertOne([
                $engineModel->getName(),
                $engineModel->getManufacturer()?->getName(),
                $engineModel->getEngineFamily()?->label(),
            ]);
        }

        $io->success('The engine models have been dumped.');

        return Command::SUCCESS;
    }
}
