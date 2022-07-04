<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\PropertyValue;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PropertyValue>
 *
 * @method PropertyValue|null find($id, $lockMode = null, $lockVersion = null)
 * @method PropertyValue|null findOneBy(array $criteria, array $orderBy = null)
 * @method PropertyValue[] findAll()
 * @method PropertyValue[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PropertyValueRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PropertyValue::class);
    }

    public function add(PropertyValue $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(PropertyValue $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
