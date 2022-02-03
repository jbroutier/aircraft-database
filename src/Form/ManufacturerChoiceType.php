<?php

declare(strict_types=1);

namespace App\Form;

use App\Entity\Manufacturer;
use App\Repository\ManufacturerRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ManufacturerChoiceType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'choice_label' => 'name',
            'class' => Manufacturer::class,
            'query_builder' => function (ManufacturerRepository $repository) {
                return $repository
                    ->createQueryBuilder('m')
                    ->addOrderBy('m.name', 'ASC');
            },
        ]);
    }

    public function getParent(): string
    {
        return EntityType::class;
    }
}
