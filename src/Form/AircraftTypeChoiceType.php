<?php

declare(strict_types=1);

namespace App\Form;

use App\Entity\AircraftType;
use App\Repository\AircraftTypeRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AircraftTypeChoiceType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'choice_label' => 'name',
            'class' => AircraftType::class,
            'group_by' => function (AircraftType $aircraftType) {
                return $aircraftType
                    ->getManufacturer()
                    ?->getName();
            },
            'query_builder' => function (AircraftTypeRepository $repository) {
                return $repository
                    ->createQueryBuilder('at')
                    ->leftJoin('at.manufacturer', 'm')
                    ->addOrderBy('m.name', 'ASC')
                    ->addOrderBy('at.name', 'ASC');
            },
        ]);
    }

    public function getParent(): string
    {
        return EntityType::class;
    }
}
