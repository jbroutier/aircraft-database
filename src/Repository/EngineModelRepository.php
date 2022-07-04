<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\EngineModel;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<EngineModel>
 *
 * @method EngineModel|null find($id, $lockMode = null, $lockVersion = null)
 * @method EngineModel|null findOneBy(array $criteria, array $orderBy = null)
 * @method EngineModel[] findAll()
 * @method EngineModel[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EngineModelRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EngineModel::class);
    }

    public function add(EngineModel $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(EngineModel $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
