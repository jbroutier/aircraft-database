<?php

declare(strict_types=1);

namespace App\Repository\Traits;

use Doctrine\ORM\QueryBuilder;

trait SortableTrait
{
    /**
     * @param array<string, string|null> $orderBy
     */
    protected function applyOrder(QueryBuilder $builder, array $orderBy = []): void
    {
        $rootAlias = $builder->getRootAliases()[0];
        /** @psalm-var class-string<object> $rootEntity */
        $rootEntity = $builder->getRootEntities()[0];

        $classMetadata = $builder
            ->getEntityManager()
            ->getClassMetadata($rootEntity);

        foreach ($orderBy as $sort => $order) {
            if (is_string($order) && in_array(strtolower($order), ['asc', 'desc'], true)) {
                if ($classMetadata->hasField($sort)) {
                    $builder->addOrderBy($rootAlias . '.' . $sort, $order);
                } elseif ($classMetadata->hasAssociation($sort)) {
                    $builder
                        ->leftJoin($rootAlias . '.' . $sort, $sort)
                        ->addOrderBy($sort . '.name', $order);
                }
            }
        }

        if (count(array_filter($orderBy)) === 0) {
            $builder->addOrderBy($rootAlias . '.name', 'ASC');
        }
    }
}
