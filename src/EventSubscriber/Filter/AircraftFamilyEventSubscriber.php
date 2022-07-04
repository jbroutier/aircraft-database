<?php

declare(strict_types=1);

namespace App\EventSubscriber\Filter;

use App\Enum\AircraftFamily;
use Doctrine\ORM\QueryBuilder;
use Lexik\Bundle\FormFilterBundle\Event\GetFilterConditionEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class AircraftFamilyEventSubscriber implements EventSubscriberInterface
{
    /**
     * @codeCoverageIgnore
     */
    public static function getSubscribedEvents(): array
    {
        return [
            'lexik_form_filter.apply.orm.filter_aircraft_family' => 'filterAircraftFamily',
        ];
    }

    public function filterAircraftFamily(GetFilterConditionEvent $event): void
    {
        $values = $event->getValues();

        if ($values['value'] instanceof AircraftFamily) {
            /** @var QueryBuilder $builder */
            $builder = $event->getQueryBuilder();
            $builder
                ->andWhere($builder->expr()->eq($event->getField(), ':aircraftFamily'))
                ->setParameter(':aircraftFamily', $values['value']);
        }
    }
}
