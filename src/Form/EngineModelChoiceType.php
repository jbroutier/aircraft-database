<?php

declare(strict_types=1);

namespace App\Form;

use App\Entity\EngineModel;
use App\Repository\EngineModelRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EngineModelChoiceType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'choice_label' => 'name',
            'class' => EngineModel::class,
            'group_by' => function (EngineModel $engineModel) {
                return $engineModel
                    ->getManufacturer()
                    ?->getName();
            },
            'query_builder' => function (EngineModelRepository $repository) {
                return $repository
                    ->createQueryBuilder('em')
                    ->leftJoin('em.manufacturer', 'm')
                    ->addOrderBy('m.name', 'ASC')
                    ->addOrderBy('em.name', 'ASC');
            },
        ]);
    }

    public function getParent(): string
    {
        return EntityType::class;
    }
}
