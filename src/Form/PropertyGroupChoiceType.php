<?php

declare(strict_types=1);

namespace App\Form;

use App\Entity\PropertyGroup;
use App\Repository\PropertyGroupRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PropertyGroupChoiceType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'choice_label' => 'name',
            'class' => PropertyGroup::class,
            'query_builder' => function (PropertyGroupRepository $repository) {
                return $repository
                    ->createQueryBuilder('pg')
                    ->addOrderBy('pg.name', 'ASC');
            },
        ]);
    }

    public function getParent(): string
    {
        return EntityType::class;
    }
}
