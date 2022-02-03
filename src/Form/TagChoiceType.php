<?php

declare(strict_types=1);

namespace App\Form;

use App\Entity\Tag;
use App\Repository\TagRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TagChoiceType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'choice_label' => 'name',
            'class' => Tag::class,
            'query_builder' => function (TagRepository $repository) {
                return $repository
                    ->createQueryBuilder('t')
                    ->addOrderBy('t.name', 'ASC');
            },
        ]);
    }

    public function getParent(): string
    {
        return EntityType::class;
    }
}
