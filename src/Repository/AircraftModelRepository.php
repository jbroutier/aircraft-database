<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\AircraftModel;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AircraftModel>
 *
 * @method AircraftModel|null find($id, $lockMode = null, $lockVersion = null)
 * @method AircraftModel|null findOneBy(array $criteria, array $orderBy = null)
 * @method AircraftModel[] findAll()
 * @method AircraftModel[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AircraftModelRepository extends ServiceEntityRepository
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AircraftModel::class);
    }

    public function add(AircraftModel $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(AircraftModel $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
