<?php

declare(strict_types=1);

namespace App\DataFixtures\Traits;

use App\Entity\Interface\PropertiesAwareInterface;
use App\Entity\Property;
use App\Entity\PropertyValue;
use App\Enum\PropertyType;
use Faker\Generator;

trait PropertiesTrait
{
    /**
     * @param array<Property> $properties
     */
    protected function addProperties(Generator $generator, PropertiesAwareInterface $entity, array $properties): void
    {
        for ($i = 0; $i < $generator->numberBetween(20, 40); $i++) {
            $property = $generator->randomElement($properties);

            $value = (string)match ($property->getType()) {
                PropertyType::Boolean => $generator->boolean() ? 'true' : 'false',
                PropertyType::Float => $generator->randomFloat(),
                PropertyType::Integer => $generator->randomNumber(),
                PropertyType::String => $generator->word(),
                PropertyType::Url => $generator->url(),
                default => throw new \LogicException('Unhandled property type'),
            };

            $propertyValue = new PropertyValue();
            $propertyValue
                ->setProperty($property)
                ->setValue($value);

            $entity->addPropertyValue($propertyValue);
        }
    }
}
