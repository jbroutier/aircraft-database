<?php

declare(strict_types=1);

namespace App\EventSubscriber\Filter;

use Doctrine\ORM\QueryBuilder;
use Lexik\Bundle\FormFilterBundle\Event\GetFilterConditionEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class CountryEventSubscriber implements EventSubscriberInterface
{
    /**
     * @codeCoverageIgnore
     */
    public static function getSubscribedEvents(): array
    {
        return [
            'lexik_form_filter.apply.orm.filter_country' => 'filterCountry',
        ];
    }

    public function filterCountry(GetFilterConditionEvent $event): void
    {
        $values = $event->getValues();

        if (is_string($values['value'])) {
            /** @var QueryBuilder $builder */
            $builder = $event->getQueryBuilder();
            $builder
                ->andWhere($builder->expr()->eq($event->getField(), ':country'))
                ->setParameter(':country', $values['value']);
        }
    }
}
