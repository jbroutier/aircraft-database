<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\EngineModel;
use App\Repository\Traits\FilterableTrait;
use App\Repository\Traits\SortableTrait;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Pagerfanta\Doctrine\ORM\QueryAdapter;
use Pagerfanta\Pagerfanta;

/**
 * @method EngineModel|null find($id, $lockMode = null, $lockVersion = null)
 * @method EngineModel|null findOneBy(array $criteria, array $orderBy = null)
 * @method EngineModel[]    findAll()
 * @method EngineModel[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 *
 * @extends ServiceEntityRepository<EngineModel>
 */
class EngineModelRepository extends ServiceEntityRepository
{
    use FilterableTrait;
    use SortableTrait;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EngineModel::class);
    }

    /**
     * @param array<string, mixed> $filters
     * @param array<string, string|null> $orderBy
     * @return Pagerfanta<EngineModel>
     */
    public function findPaginated(array $filters = [], array $orderBy = []): Pagerfanta
    {
        $builder = $this->createQueryBuilder('em');
        $this->applyFilters($builder, $filters);
        $this->applyOrder($builder, $orderBy);

        return new Pagerfanta(new QueryAdapter($builder));
    }
}
