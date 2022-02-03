<?php

declare(strict_types=1);

namespace App\Form;

use App\Entity\Property;
use App\Repository\PropertyRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PropertyChoiceType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'choice_label' => 'name',
            'class' => Property::class,
            'group_by' => function (Property $property) {
                return $property
                    ->getPropertyGroup()
                    ?->getName();
            },
            'query_builder' => function (PropertyRepository $repository) {
                return $repository
                    ->createQueryBuilder('p')
                    ->leftJoin('p.propertyGroup', 'pg')
                    ->addOrderBy('pg.name', 'ASC')
                    ->addOrderBy('p.name', 'ASC');
            },
        ]);
    }

    public function getParent(): string
    {
        return EntityType::class;
    }
}
