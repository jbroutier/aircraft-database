<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\PropertyGroup;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PropertyGroup>
 *
 * @method PropertyGroup|null find($id, $lockMode = null, $lockVersion = null)
 * @method PropertyGroup|null findOneBy(array $criteria, array $orderBy = null)
 * @method PropertyGroup[] findAll()
 * @method PropertyGroup[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PropertyGroupRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PropertyGroup::class);
    }

    public function add(PropertyGroup $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(PropertyGroup $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
