<?php

declare(strict_types=1);

namespace App\Form;

use Lexik\Bundle\FormFilterBundle\Filter\FilterOperands;
use Lexik\Bundle\FormFilterBundle\Filter\Form\Type\TextFilterType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserFiltersType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', TextFilterType::class, [
                'condition_pattern' => FilterOperands::STRING_CONTAINS,
                'required' => false,
            ])
            ->add('firstName', TextFilterType::class, [
                'condition_pattern' => FilterOperands::STRING_CONTAINS,
                'required' => false,
            ])
            ->add('lastName', TextFilterType::class, [
                'condition_pattern' => FilterOperands::STRING_CONTAINS,
                'required' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'csrf_protection' => false,
            'validation_groups' => false,
        ]);
    }

    public function getBlockPrefix(): string
    {
        return 'filters';
    }
}
