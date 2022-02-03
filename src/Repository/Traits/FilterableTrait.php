<?php

declare(strict_types=1);

namespace App\Repository\Traits;

use App\Entity\AircraftType;
use App\Entity\Manufacturer;
use App\Entity\PropertyGroup;
use App\Enum\Operator;
use App\Enum\PropertyType;
use Doctrine\ORM\QueryBuilder;

trait FilterableTrait
{
    /**
     * @param array<string, mixed> $filters
     */
    public function applyFilters(QueryBuilder $builder, array $filters): void
    {
        $rootAlias = $builder->getRootAliases()[0];
        $rootEntity = $builder->getRootEntities()[0];

        $classMetadata = $builder
            ->getEntityManager()
            ->getClassMetadata($rootEntity);

        if (array_key_exists('aircraftType', $filters) && $filters['aircraftType'] instanceof AircraftType) {
            if ($classMetadata->hasAssociation('aircraftType')) {
                $builder
                    ->andWhere($builder->expr()->eq($rootAlias . '.aircraftType', ':aircraftType'))
                    ->setParameter(':aircraftType', $filters['aircraftType']->getId(), 'uuid');
            }
        }

        if (array_key_exists('country', $filters) && is_string($filters['country'])) {
            if ($classMetadata->hasField('country')) {
                $builder
                    ->andWhere($builder->expr()->eq($rootAlias . '.country', ':country'))
                    ->setParameter(':country', $filters['country'], 'string');
            }
        }

        if (array_key_exists('iataCode', $filters) && is_string($filters['iataCode'])) {
            if ($classMetadata->hasField('iataCode')) {
                $builder
                    ->andWhere($builder->expr()->eq($rootAlias . '.iataCode', ':iataCode'))
                    ->setParameter(':iataCode', $filters['iataCode'], 'string');
            }
        }

        if (array_key_exists('icaoCode', $filters) && is_string($filters['icaoCode'])) {
            if ($classMetadata->hasField('icaoCode')) {
                $builder
                    ->andWhere($builder->expr()->eq($rootAlias . '.icaoCode', ':icaoCode'))
                    ->setParameter(':icaoCode', $filters['icaoCode'], 'string');
            }
        }

        if (array_key_exists('manufacturer', $filters) && $filters['manufacturer'] instanceof Manufacturer) {
            if ($classMetadata->hasAssociation('manufacturer')) {
                $builder
                    ->andWhere($builder->expr()->eq($rootAlias . '.manufacturer', ':manufacturer'))
                    ->setParameter(':manufacturer', $filters['manufacturer']->getId(), 'uuid');
            }
        }

        if (array_key_exists('name', $filters) && is_string($filters['name'])) {
            if ($classMetadata->hasField('name')) {
                $builder
                    ->andWhere($builder->expr()->like($rootAlias . '.name', ':name'))
                    ->setParameter(':name', '%' . $filters['name'] . '%', 'string');
            }
        }

        if (array_key_exists('propertyGroup', $filters) && $filters['propertyGroup'] instanceof PropertyGroup) {
            if ($classMetadata->hasAssociation('propertyGroup')) {
                $builder
                    ->andWhere($builder->expr()->eq($rootAlias . '.propertyGroup', ':propertyGroup'))
                    ->setParameter(':propertyGroup', $filters['propertyGroup']->getId(), 'uuid');
            }
        }

        if (array_key_exists('propertyType', $filters) && $filters['propertyType'] instanceof PropertyType) {
            if ($classMetadata->hasAssociation('propertyType')) {
                $builder
                    ->andWhere($builder->expr()->eq($rootAlias . '.propertyType', ':propertyType'))
                    ->setParameter(':propertyType', $filters['propertyType'], 'uuid');
            }
        }

        if (array_key_exists('propertyValues', $filters) && is_array($filters['propertyValues'])) {
            if ($classMetadata->hasAssociation('propertyValues')) {
                $builder
                    ->leftJoin($rootAlias . '.propertyValues', 'pv')
                    ->leftJoin('pv.property', 'p');

                foreach ($filters['propertyValues'] as $index => $filter) {
                    $criteria = match ($filter['operator']) {
                        Operator::Equal => $builder->expr()->eq('pv.value', ':value' . $index),
                        Operator::NotEqual => $builder->expr()->neq('pv.value', ':value' . $index),
                        Operator::GreaterThan => $builder->expr()->gt('pv.value', ':value' . $index),
                        Operator::GreaterThanOrEqual => $builder->expr()->gte('pv.value', ':value' . $index),
                        Operator::LessThan => $builder->expr()->lt('pv.value', ':value' . $index),
                        Operator::LessThanOrEqual => $builder->expr()->lte('pv.value', ':value' . $index),
                        default => throw new \LogicException('Unhandled operator'),
                    };

                    $builder
                        ->andWhere($criteria)
                        ->setParameter(':value' . $index, $filter['value']);
                }
            }
        }
    }
}
