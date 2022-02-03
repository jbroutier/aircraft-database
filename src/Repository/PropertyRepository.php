<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Property;
use App\Repository\Traits\FilterableTrait;
use App\Repository\Traits\SortableTrait;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Pagerfanta\Doctrine\ORM\QueryAdapter;
use Pagerfanta\Pagerfanta;

/**
 * @method Property|null find($id, $lockMode = null, $lockVersion = null)
 * @method Property|null findOneBy(array $criteria, array $orderBy = null)
 * @method Property[]    findAll()
 * @method Property[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 *
 * @extends ServiceEntityRepository<Property>
 */
class PropertyRepository extends ServiceEntityRepository
{
    use FilterableTrait;
    use SortableTrait;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Property::class);
    }

    /**
     * @param array<string, mixed> $filters
     * @param array<string, string|null> $orderBy
     * @return Pagerfanta<Property>
     */
    public function findPaginated(array $filters = [], array $orderBy = []): Pagerfanta
    {
        $builder = $this->createQueryBuilder('p');
        $this->applyFilters($builder, $filters);
        $this->applyOrder($builder, $orderBy);

        return new Pagerfanta(new QueryAdapter($builder));
    }
}
