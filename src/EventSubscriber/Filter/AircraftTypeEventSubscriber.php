<?php

declare(strict_types=1);

namespace App\EventSubscriber\Filter;

use App\Entity\AircraftType;
use Doctrine\ORM\QueryBuilder;
use Lexik\Bundle\FormFilterBundle\Event\GetFilterConditionEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class AircraftTypeEventSubscriber implements EventSubscriberInterface
{
    /**
     * @codeCoverageIgnore
     */
    public static function getSubscribedEvents(): array
    {
        return [
            'lexik_form_filter.apply.orm.filter_aircraft_type' => 'filterAircraftType',
        ];
    }

    public function filterAircraftType(GetFilterConditionEvent $event): void
    {
        $values = $event->getValues();

        if ($values['value'] instanceof AircraftType) {
            /** @var QueryBuilder $builder */
            $builder = $event->getQueryBuilder();
            $builder
                ->andWhere($builder->expr()->eq($event->getField(), ':aircraftType'))
                ->setParameter(':aircraftType', $values['value']->getId(), 'uuid');
        }
    }
}
