<?php

declare(strict_types=1);

namespace App\Form;

use App\Entity\Manufacturer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ManufacturerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('content', TextareaType::class)
            ->add('country', CountryChoiceType::class, ['required' => false])
            ->add('logo', LogoType::class)
            ->add('name', TextType::class)
            ->add('pictures', PictureCollectionType::class)
            ->add('propertyValues', PropertyValueCollectionType::class)
            ->add('slug', TextType::class)
            ->add('tags', TagChoiceType::class, ['multiple' => true]);

       $builder->addEventListener(FormEvents::POST_SUBMIT, function (FormEvent $event) {
           $data = $event->getData();

           if ($data->getLogo()->getFileName() === null && $data->getLogo()->getFile() === null) {
               $data->setLogo(null);
           }

           $event->setData($data);
        });
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Manufacturer::class,
        ]);
    }
}
