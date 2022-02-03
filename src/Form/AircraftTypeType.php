<?php

declare(strict_types=1);

namespace App\Form;

use App\Entity\AircraftType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AircraftTypeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('engineModels', EngineModelChoiceType::class, ['required' => false, 'multiple' => true])
            ->add('iataCode', TextType::class)
            ->add('icaoCode', TextType::class)
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
            'data_class' => AircraftType::class,
        ]);
    }
}
