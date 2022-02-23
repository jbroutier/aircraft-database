<?php

declare(strict_types=1);

namespace Tests\Functional;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

abstract class FixturesAwareTestCase extends WebTestCase
{
    /**
     * @param class-string<T> $className
     * @param array<string, mixed> $criteria
     *
     * @return T
     *
     * @template T of object
     */
    protected function findEntityBy(string $className, array $criteria): object
    {
        /** @var EntityManager $entityManager */
        $entityManager = self::getContainer()->get('doctrine.orm.entity_manager');
        /** @var EntityRepository<T> $repository */
        $repository = $entityManager->getRepository($className);

        if (is_null($entity = $repository->findOneBy($criteria))) {
            self::fail('Entity of class "' . $className . '" could not be found.');
        }

        return $entity;
    }
}
