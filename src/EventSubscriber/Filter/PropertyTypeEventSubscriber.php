<?php

declare(strict_types=1);

namespace App\EventSubscriber\Filter;

use App\Enum\PropertyType;
use Doctrine\ORM\QueryBuilder;
use Lexik\Bundle\FormFilterBundle\Event\GetFilterConditionEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class PropertyTypeEventSubscriber implements EventSubscriberInterface
{
    /**
     * @codeCoverageIgnore
     */
    public static function getSubscribedEvents(): array
    {
        return [
            'lexik_form_filter.apply.orm.filter_property_type' => 'filterPropertyType',
        ];
    }

    public function filterPropertyType(GetFilterConditionEvent $event): void
    {
        $values = $event->getValues();

        if ($values['value'] instanceof PropertyType) {
            /** @var QueryBuilder $builder */
            $builder = $event->getQueryBuilder();
            $builder
                ->andWhere($builder->expr()->eq($event->getField(), ':propertyType'))
                ->setParameter(':propertyType', $values['value']);
        }
    }
}
