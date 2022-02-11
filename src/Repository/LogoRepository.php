<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Logo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Logo|null find($id, $lockMode = null, $lockVersion = null)
 * @method Logo|null findOneBy(array $criteria, array $orderBy = null)
 * @method Logo[]    findAll()
 * @method Logo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 *
 * @extends ServiceEntityRepository<Logo>
 */
class LogoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Logo::class);
    }
}
