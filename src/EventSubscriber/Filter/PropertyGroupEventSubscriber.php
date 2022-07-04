<?php

declare(strict_types=1);

namespace App\EventSubscriber\Filter;

use App\Entity\PropertyGroup;
use Doctrine\ORM\QueryBuilder;
use Lexik\Bundle\FormFilterBundle\Event\GetFilterConditionEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class PropertyGroupEventSubscriber implements EventSubscriberInterface
{
    /**
     * @codeCoverageIgnore
     */
    public static function getSubscribedEvents(): array
    {
        return [
            'lexik_form_filter.apply.orm.filter_property_group' => 'filterPropertyGroup',
        ];
    }

    public function filterPropertyGroup(GetFilterConditionEvent $event): void
    {
        $values = $event->getValues();

        if ($values['value'] instanceof PropertyGroup) {
            /** @var QueryBuilder $builder */
            $builder = $event->getQueryBuilder();
            $builder
                ->andWhere($builder->expr()->eq($event->getField(), ':propertyGroup'))
                ->setParameter(':propertyGroup', $values['value']->getId(), 'uuid');
        }
    }
}
