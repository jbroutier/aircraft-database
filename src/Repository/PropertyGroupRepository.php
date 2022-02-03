<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\PropertyGroup;
use App\Repository\Traits\FilterableTrait;
use App\Repository\Traits\SortableTrait;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Pagerfanta\Doctrine\ORM\QueryAdapter;
use Pagerfanta\Pagerfanta;

/**
 * @method PropertyGroup|null find($id, $lockMode = null, $lockVersion = null)
 * @method PropertyGroup|null findOneBy(array $criteria, array $orderBy = null)
 * @method PropertyGroup[]    findAll()
 * @method PropertyGroup[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 *
 * @extends ServiceEntityRepository<PropertyGroup>
 */
class PropertyGroupRepository extends ServiceEntityRepository
{
    use FilterableTrait;
    use SortableTrait;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PropertyGroup::class);
    }

    /**
     * @param array<string, mixed> $filters
     * @param array<string, string|null> $orderBy
     * @return Pagerfanta<PropertyGroup>
     */
    public function findPaginated(array $filters = [], array $orderBy = []): Pagerfanta
    {
        $builder = $this->createQueryBuilder('pg');
        $this->applyFilters($builder, $filters);
        $this->applyOrder($builder, $orderBy);

        return new Pagerfanta(new QueryAdapter($builder));
    }
}
