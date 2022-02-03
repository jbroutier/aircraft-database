<?php

declare(strict_types=1);

namespace App\Form;

use App\Entity\EngineModel;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EngineModelType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('manufacturer', ManufacturerChoiceType::class)
            ->add('name', TextType::class)
            ->add('pictures', PictureCollectionType::class)
            ->add('propertyValues', PropertyValueCollectionType::class)
            ->add('slug', TextType::class)
            ->add('tags', TagChoiceType::class, ['multiple' => true]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => EngineModel::class,
        ]);
    }
}
