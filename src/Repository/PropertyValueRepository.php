<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\PropertyValue;
use App\Repository\Traits\FilterableTrait;
use App\Repository\Traits\SortableTrait;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Pagerfanta\Doctrine\ORM\QueryAdapter;
use Pagerfanta\Pagerfanta;

/**
 * @method PropertyValue|null find($id, $lockMode = null, $lockVersion = null)
 * @method PropertyValue|null findOneBy(array $criteria, array $orderBy = null)
 * @method PropertyValue[]    findAll()
 * @method PropertyValue[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 *
 * @extends ServiceEntityRepository<PropertyValue>
 */
class PropertyValueRepository extends ServiceEntityRepository
{
    use FilterableTrait;
    use SortableTrait;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PropertyValue::class);
    }

    /**
     * @param array<string, mixed> $filters
     * @param array<string, string|null> $orderBy
     * @return Pagerfanta<PropertyValue>
     */
    public function findPaginated(array $filters = [], array $orderBy = []): Pagerfanta
    {
        $builder = $this->createQueryBuilder('pv');
        $this->applyFilters($builder, $filters);
        $this->applyOrder($builder, $orderBy);

        return new Pagerfanta(new QueryAdapter($builder));
    }
}
