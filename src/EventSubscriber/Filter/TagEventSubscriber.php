<?php

declare(strict_types=1);

namespace App\EventSubscriber\Filter;

use App\Entity\Tag;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\QueryBuilder;
use Lexik\Bundle\FormFilterBundle\Event\GetFilterConditionEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class TagEventSubscriber implements EventSubscriberInterface
{
    /**
     * @codeCoverageIgnore
     */
    public static function getSubscribedEvents(): array
    {
        return [
            'lexik_form_filter.apply.orm.filter_tag' => 'filterTag',
        ];
    }

    public function filterTag(GetFilterConditionEvent $event): void
    {
        $values = $event->getValues();

        if ($values['value'] instanceof Collection && !$values['value']->isEmpty()) {
            /** @var QueryBuilder $builder */
            $builder = $event->getQueryBuilder();
            $builder->leftJoin($event->getField(), 't');

            /** @var Tag[] $tags */
            $tags = $values['value'];
            $criteria = $builder->expr()->orX();

            foreach ($tags as $index => $tag) {
                $criteria->add($builder->expr()->eq('t.id', ':tag' . $index));
                $builder->setParameter(':tag' . $index, $tag->getId(), 'uuid');
            }

            $builder
                ->addGroupBy($values['alias'] . '.id')
                ->andWhere($criteria)
                ->andHaving($builder->expr()->eq($builder->expr()->countDistinct('t.id'), count($values['value'])));
        }
    }
}
