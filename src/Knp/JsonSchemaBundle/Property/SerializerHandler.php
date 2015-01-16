<?php

namespace Knp\JsonSchemaBundle\Property;

use Doctrine\Common\Inflector\Inflector;
use JMS\Serializer\Naming\PropertyNamingStrategyInterface;
use Knp\JsonSchemaBundle\Model\Property;
use Knp\JsonSchemaBundle\Schema\SchemaRegistry;
use Metadata\MetadataFactoryInterface;
use Symfony\Component\Form\Guess\TypeGuess;
use Symfony\Component\Form\FormTypeGuesserInterface;

class SerializerHandler implements PropertyHandlerInterface
{
    protected $factory;
    protected $namingStrategy;

    public function __construct(MetadataFactoryInterface $factory, PropertyNamingStrategyInterface $namingStrategy)
    {
        $this->factory        = $factory;
        $this->namingStrategy = $namingStrategy;

    }

    public function handle($className, Property $property)
    {
        $meta = $this->factory->getMetadataForClass($className);

        foreach ($meta->propertyMetadata as $item) {
            if (!(is_null($item->type))) {
                if ($item->name === $property->getName()) {
                    $property->addType($this->getPropertyType($item->type));
                    $property->setFormat($this->getPropertyFormat($item->type));
                }
            }
        }
    }

    private function getPropertyType(array $type)
    {
        switch ($type['name']) {
            case 'ArrayCollection':
            case 'array':
                return Property::TYPE_ARRAY;
            case 'boolean':
                return Property::TYPE_BOOLEAN;
            case 'float':
            case 'double':
            case 'number':
                return Property::TYPE_NUMBER;
            case 'integer':
                return Property::TYPE_INTEGER;
            case 'date':
            case 'datetime':
            case 'text':
            case 'textarea':
            case 'country':
            case 'email':
            case 'file':
            case 'language':
            case 'locale':
            case 'time':
            case 'string':
                return Property::TYPE_STRING;
        }
    }

    private function getPropertyFormat(array $type)
    {
        switch ($type['name']) {
            case 'ArrayCollection':
            case 'array':
                return Property::TYPE_ARRAY;
            case 'boolean':
                return Property::TYPE_BOOLEAN;
            case 'float':
            case 'double':
            case 'number':
                return Property::TYPE_NUMBER;
            case 'integer':
                return Property::TYPE_INTEGER;
            case 'date':
            case 'datetime':
            case 'text':
            case 'textarea':
            case 'country':
            case 'email':
            case 'file':
            case 'language':
            case 'locale':
            case 'time':
            case 'string':
                return Property::TYPE_STRING;
        }
    }
}