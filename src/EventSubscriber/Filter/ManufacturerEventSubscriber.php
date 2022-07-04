<?php

declare(strict_types=1);

namespace App\EventSubscriber\Filter;

use App\Entity\Manufacturer;
use Doctrine\ORM\QueryBuilder;
use Lexik\Bundle\FormFilterBundle\Event\GetFilterConditionEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class ManufacturerEventSubscriber implements EventSubscriberInterface
{
    /**
     * @codeCoverageIgnore
     */
    public static function getSubscribedEvents(): array
    {
        return [
            'lexik_form_filter.apply.orm.filter_manufacturer' => 'filterManufacturer',
        ];
    }

    public function filterManufacturer(GetFilterConditionEvent $event): void
    {
        $values = $event->getValues();

        if ($values['value'] instanceof Manufacturer) {
            /** @var QueryBuilder $builder */
            $builder = $event->getQueryBuilder();
            $builder
                ->andWhere($builder->expr()->eq($event->getField(), ':manufacturer'))
                ->setParameter(':manufacturer', $values['value']->getId(), 'uuid');
        }
    }
}
