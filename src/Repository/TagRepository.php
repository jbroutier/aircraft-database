<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Tag;
use App\Repository\Traits\FilterableTrait;
use App\Repository\Traits\SortableTrait;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Pagerfanta\Doctrine\ORM\QueryAdapter;
use Pagerfanta\Pagerfanta;

/**
 * @method Tag|null find($id, $lockMode = null, $lockVersion = null)
 * @method Tag|null findOneBy(array $criteria, array $orderBy = null)
 * @method Tag[]    findAll()
 * @method Tag[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 *
 * @extends ServiceEntityRepository<Tag>
 */
class TagRepository extends ServiceEntityRepository
{
    use FilterableTrait;
    use SortableTrait;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Tag::class);
    }

    /**
     * @param array<string, mixed> $filters
     * @param array<string, string|null> $orderBy
     * @return Pagerfanta<Tag>
     */
    public function findPaginated(array $filters = [], array $orderBy = []): Pagerfanta
    {
        $builder = $this->createQueryBuilder('t');
        $this->applyFilters($builder, $filters);
        $this->applyOrder($builder, $orderBy);

        return new Pagerfanta(new QueryAdapter($builder));
    }
}
