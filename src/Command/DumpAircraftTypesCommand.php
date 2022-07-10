<?php

declare(strict_types=1);

namespace App\Command;

use App\Entity\AircraftType;
use App\Repository\AircraftTypeRepository;
use Doctrine\ORM\Query;
use League\Csv\Writer;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

#[AsCommand(
    name: 'dump:aircraft-types',
    description: 'Dump the aircraft types',
)]
class DumpAircraftTypesCommand extends Command
{
    public function __construct(
        protected readonly AircraftTypeRepository $repository,
        #[Autowire(value: '%kernel.project_dir%/dump')]
        protected readonly string $directory
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        /** @var AircraftType[] $aircraftTypes */
        $aircraftTypes = $this->repository
            ->createQueryBuilder('at')
            ->select('PARTIAL at.{id, aircraftFamily, engineCount, engineFamily, iataCode, icaoCode, name}')
            ->addSelect('PARTIAL m.{id, name}')
            ->leftJoin('at.manufacturer', 'm')
            ->addOrderBy('at.name', 'ASC')
            ->getQuery()
            ->setHint(Query::HINT_FORCE_PARTIAL_LOAD, true)
            ->getResult();

        $csv = Writer::createFromPath($this->directory . '/aircraft-types.csv', 'w');
        $csv->insertOne(['name', 'manufacturer', 'aircraft-family', 'engine-type', 'engine-count']);

        foreach ($aircraftTypes as $aircraftType) {
            $csv->insertOne([
                $aircraftType->getName(),
                $aircraftType->getManufacturer()?->getName(),
                $aircraftType->getAircraftFamily()?->label(),
                $aircraftType->getEngineFamily()?->label(),
                $aircraftType->getEngineCount(),
                $aircraftType->getIataCode(),
                $aircraftType->getIcaoCode(),
            ]);
        }

        $io->success('The aircraft types have been dumped.');

        return Command::SUCCESS;
    }
}
