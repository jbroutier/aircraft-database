<?php

declare(strict_types=1);

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PropertyValueCollectionType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'allow_add' => true,
            'allow_delete' => true,
            'entry_type' => PropertyValueCollectionItemType::class,
        ]);
    }

    public function finishView(FormView $view, FormInterface $form, array $options): void
    {
        usort($view->children, function (FormView $a, FormView $b) {
            return $a->vars['value']->getProperty()->getName() <=> $b->vars['value']->getProperty()->getName();
        });
    }

    public function getParent(): string
    {
        return CollectionType::class;
    }
}
