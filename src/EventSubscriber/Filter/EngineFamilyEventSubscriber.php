<?php

declare(strict_types=1);

namespace App\EventSubscriber\Filter;

use App\Enum\EngineFamily;
use Doctrine\ORM\QueryBuilder;
use Lexik\Bundle\FormFilterBundle\Event\GetFilterConditionEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class EngineFamilyEventSubscriber implements EventSubscriberInterface
{
    /**
     * @codeCoverageIgnore
     */
    public static function getSubscribedEvents(): array
    {
        return [
            'lexik_form_filter.apply.orm.filter_engine_family' => 'filterEngineFamily',
        ];
    }

    public function filterEngineFamily(GetFilterConditionEvent $event): void
    {
        $values = $event->getValues();

        if ($values['value'] instanceof EngineFamily) {
            /** @var QueryBuilder $builder */
            $builder = $event->getQueryBuilder();
            $builder
                ->andWhere($builder->expr()->eq($event->getField(), ':engineFamily'))
                ->setParameter(':engineFamily', $values['value']);
        }
    }
}
