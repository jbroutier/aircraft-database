<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\AircraftType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AircraftType>
 *
 * @method AircraftType|null find($id, $lockMode = null, $lockVersion = null)
 * @method AircraftType|null findOneBy(array $criteria, array $orderBy = null)
 * @method AircraftType[] findAll()
 * @method AircraftType[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AircraftTypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AircraftType::class);
    }

    public function add(AircraftType $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(AircraftType $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
