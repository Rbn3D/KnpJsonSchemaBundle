<?php

namespace Knp\JsonSchemaBundle\Model;

class Schema implements \JsonSerializable
{
    const TYPE_OBJECT = 'object';
    const SCHEMA_V4 = 'http://json-schema.org/draft-04/schema#';

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $description;

    /**
     * The "id" keyword is used to alter the resolution scope.  When an id is encountered, the implementation
     * must resolve against the most immediate parent scope.
     *
     * @var string
     */
    private $id;

    /**
     * @var
     */
    private $type;

    /**
     * This keyword MUST be a URL and a valid JSON reference.  Use a default or link to a customized schema.
     *
     * @var string
     */
    private $schema;

    /**
     * @var Property[]
     */
    private $properties;


    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     *
     * @return Schema
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function getProperties()
    {
        return $this->properties;
    }

    public function addProperty(Property $property)
    {
        $this->properties[$property->getName()] = $property;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setType($type)
    {
        $this->type = $type;
    }

    public function getSchema()
    {
        return $this->schema;
    }

    public function setSchema($schema)
    {
        $this->schema = $schema;
    }

    public function jsonSerialize()
    {
        $properties = array();

        foreach ($this->properties as $i => $property) {
            $properties[$i] = $property->jsonSerialize();
        }

        $serialized = array(
            'title'      => $this->title,
            'type'       => $this->type,
            '$schema'    => $this->schema,
            'id'         => $this->id,
            'properties' => $this->properties,
        );

        $requiredProperties = array_keys(array_filter($this->properties, function ($property) {
            return $property->isRequired();
        }));

        if (count($requiredProperties) > 0) {
            $serialized['required'] = $requiredProperties;
        }

        return $serialized;
    }
}
