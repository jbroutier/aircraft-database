<?php

declare(strict_types=1);

namespace App\Command;

use App\Entity\Manufacturer;
use App\Repository\ManufacturerRepository;
use Doctrine\ORM\Query;
use League\Csv\Writer;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

#[AsCommand(
    name: 'dump:manufacturers',
    description: 'Dump the manufacturers',
)]
class DumpManufacturersCommand extends Command
{
    public function __construct(
        protected readonly ManufacturerRepository $repository,
        #[Autowire(value: '%kernel.project_dir%/dump')]
        protected readonly string $directory
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        /** @var Manufacturer[] $manufacturers */
        $manufacturers = $this->repository
            ->createQueryBuilder('m')
            ->select('PARTIAL m.{id, country, name}')
            ->addOrderBy('m.name', 'ASC')
            ->getQuery()
            ->setHint(Query::HINT_FORCE_PARTIAL_LOAD, true)
            ->getResult();

        $csv = Writer::createFromPath($this->directory . '/manufacturers.csv', 'w');
        $csv->insertOne(['name', 'country']);

        foreach ($manufacturers as $manufacturer) {
            $csv->insertOne([
                $manufacturer->getName(),
                $manufacturer->getCountry(),
            ]);
        }

        $io->success('The manufacturers have been dumped.');

        return Command::SUCCESS;
    }
}
